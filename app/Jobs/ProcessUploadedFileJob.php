<?php

namespace App\Jobs;

use App\Models\UploadedFile;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;

class ProcessUploadedFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $uploadedFile;

    public function __construct(UploadedFile $uploadedFile)
    {
        $this->uploadedFile = $uploadedFile;
    }

    public function handle()
{
    try {
        $uploadedFile = UploadedFile::find($this->uploadedFile->id);

        $uploadedFile->processing_status = 'processing';
        $uploadedFile->updated_at = Carbon::now();
        $uploadedFile->save();

        if (str_contains($uploadedFile->mime_type, 'image')) {
            $manager = new ImageManager(new GdDriver());
            $image = $manager->read(Storage::disk('public')->path($uploadedFile->path));

            Storage::disk('public')->makeDirectory('thumbnails');
            $thumbnailPath = 'thumbnails/' . basename($uploadedFile->path);

            $image->resize(300, 300)->save(Storage::disk('public')->path($thumbnailPath));

            $uploadedFile->thumbnail_path = $thumbnailPath;
            $uploadedFile->processing_status = 'processed';
            $uploadedFile->updated_at = Carbon::now();
            $uploadedFile->save();
        } else {
            $uploadedFile->processing_status = 'processed';
            $uploadedFile->updated_at = Carbon::now();
            $uploadedFile->save();
        }
    } catch (\Exception $e) {
        $uploadedFile = UploadedFile::find($this->uploadedFile->id);
        $uploadedFile->processing_status = 'failed';
        $uploadedFile->updated_at = Carbon::now();
        $uploadedFile->save();
    }
}
}
