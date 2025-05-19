<?php

namespace App\Services\Api\V1\User;

use App\Enums\Deleted;
use App\Enums\Status;
use App\Helpers\FileUploadHelper;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;

class PostService
{
    protected $pagination_limit;
    protected $imageManager;
    public function __construct()
    {
        $this->pagination_limit = env('PAGINATION_LIMIT', 20);
        $this->imageManager = new ImageManager(new GdDriver());
    }

    public function getAllPosts($request)
    {
        $user = auth('api')->user();
        $posts = Post::where('user_id', $user->id)
            ->where('deleted', Deleted::NO->value)
            ->orderBy('created_at', 'desc')
            ->paginate($this->pagination_limit);

        return $posts;
    }

    public function storePost($request)
    {
        $user = auth('api')->user();
        $slug = $this->generateUniqueSlug($request->title);
        $post = new Post();
        $post->user_id = $user->id;
        $post->title = $request->title;
        $post->slug = $slug;
        $post->content = $request->content;

        if ($request->hasFile('image')) {
            $ext = $request->file('image')->getClientOriginalExtension();
            $imageName = 'user-' . time() . rand(1000, 9999) . '.' . $ext;
            $filePath = FileUploadHelper::getUploadPath() . '/user/';

            if (!file_exists($filePath)) {
                mkdir($filePath, 0755, true);
            }

            $imageFullPath = $filePath . $imageName;
            $dbImagePath = 'storage/user/' . $imageName;

            $image = $this->imageManager->read($request->file('image')->getPathname());
            $image->save($imageFullPath);

            $post->image = $dbImagePath;
        }

        $post->status = Status::ACTIVE->value;
        $post->created_at = Carbon::now();
        $post->created_by = $user->id;
        $post->save();

        return $post;
    }

    public function updatePost($request, $postId)
    {
        $user = auth('api')->user();
        $post = Post::where('id', $postId)
            ->where('deleted', Deleted::NO->value)
            ->first();

        if (!$post) {
            throw new \Exception('Post not found');
        }

        $slug = $this->generateUniqueSlug($request->title, $postId);
        $post->title = $request->title;
        $post->slug = $slug;
        $post->content = $request->content;

        if ($request->hasFile('image')) {
            if ($post->image && file_exists(public_path($post->image))) {
                unlink(public_path($post->image));
            }
            $ext = $request->file('image')->getClientOriginalExtension();
            $image_url = "user-" . time() . rand(1000, 9999) .'.'. $ext;
            $image_directory = FileUploadHelper::getUploadPath() . '/user/';
            $filePath = $image_directory;
            $image_path = $filePath . $image_url;
            $db_image_path = 'storage/user/'. $image_url;

            if (!file_exists($filePath)) {
                mkdir($filePath, 0755, true);
            }

            $image = $this->imageManager->read($request->file('image')->getPathname());
            $image->save($image_path);

            $post->image = $db_image_path;
        }

        $post->updated_at = Carbon::now();
        $post->updated_by = $user->id;
        $post->save();

        return $post;
    }

    public function getPostById($postId)
    {
        $user = auth('api')->user();
        $post = Post::where('id', $postId)
            ->where('deleted', Deleted::NO->value)
            ->first();

        if (!$post) {
            throw new \Exception('Post not found');
        }

        return $post;
    }

    public function deletePost($postId, $userId)
    {
        $post = Post::where('id', $postId)
            ->where('deleted', Deleted::NO->value)
            ->first();

        if (!$post) {
            throw new \Exception('Post not found');
        }

        $post->deleted = Deleted::YES->value;
        $post->deleted_at = Carbon::now();
        $post->deleted_by = $userId;
        $post->save();
    }


    private function generateUniqueSlug($title, $postId = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (
            Post::where('slug', $slug)
                ->where('deleted', Deleted::NO->value)
                ->when($postId, fn($q) => $q->where('id', '<>', $postId))
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }

}
