<?php

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Controllers\Api\V1\V1ResponseController;
use App\Http\Resources\Api\V1\User\PostResource;
use App\Services\Api\V1\User\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends V1ResponseController
{
    private $service;

    public function __construct(PostService $postService)
    {
        $this->service = $postService;
    }

    public function index(Request $request)
    {
        try {
            $posts = $this->service->getAllPosts($request);
            $resourceCollection = PostResource::collection($posts);
            return $this->successPaginatedResponse($posts,$resourceCollection, 'Posts retrieved successfully.');
        } catch (\Exception $e) {
            return $this->serverError($e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {

            $validator =  Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);
            if ($validator->fails()) {
                return $this->validationError($validator->errors());
            }

            $post = $this->service->storePost($request);
            return $this->successResponse(new PostResource($post), 'Post created successfully.', 201);
        } catch (\Exception $e) {
            return $this->serverError($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator =  Validator::make($request->all(), [
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);
            if ($validator->fails()) {
                return $this->validationError($validator->errors());
            }
            $post = $this->service->updatePost($request, $id);
            return $this->successResponse(new PostResource($post), 'Post updated successfully.');
        } catch (\Exception $e) {
            return $this->serverError($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $post = $this->service->getPostById($id);
            return $this->successResponse(new PostResource($post), 'Post retrieved successfully.');
        } catch (\Exception $e) {
            return $this->serverError($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $userId = auth('api')->id();
            $this->service->deletePost($id, $userId);
            return $this->successResponse([], 'Post deleted successfully.', 204);
        } catch (\Exception $e) {
            return $this->serverError($e->getMessage());
        }
    }
}
