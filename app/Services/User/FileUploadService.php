<?php

namespace App\Services\User;

use App\Enums\Deleted;
use App\Http\Requests\User\FileUploadRequest;
use App\Jobs\ProcessUploadedFileJob;
use App\Models\UploadedFile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class FileUploadService
{
    protected $pagination_limit;
    protected $userId;

    public function __construct()
    {
        $this->pagination_limit = env('PAGINATION_LIMIT', 20);
        $this->userId = Auth::id();
    }

    public function upload(FileUploadRequest $request)
    {
        $uploadedFiles = [];
        foreach ($request->file('file') as $file) {
            $path = $file->store('uploads', 'public');

            $uploadedFile = new UploadedFile();
            $uploadedFile->user_id = $this->userId;
            $uploadedFile->filename = $file->getClientOriginalName();
            $uploadedFile->path = $path;
            $uploadedFile->mime_type = $file->getClientMimeType();
            $uploadedFile->size = $file->getSize();
            $uploadedFile->processing_status = 'pending';
            $uploadedFile->created_by = Auth::id();
            $uploadedFile->created_at = Carbon::now();
            $uploadedFile->save();

            ProcessUploadedFileJob::dispatch($uploadedFile);
            $uploadedFiles[] = $uploadedFile;
        }
        return $uploadedFiles;
    }

    public function getUserFiles()
    {

        $data['files'] = UploadedFile::where('user_id', $this->userId)
            ->where('deleted', Deleted::NO->value)
            ->paginate($this->pagination_limit);

        return $data;
    }
}
