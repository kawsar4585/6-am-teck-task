<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UploadedFile extends Model
{

    protected $table = 'uploaded_files';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'filename',
        'path',
        'thumbnail_path',
        'mime_type',
        'size',
        'processing_status',
        'status',
        'created_at',
        'created_by',
        'updated_at',
        'updated_by',
        'deleted',
        'deleted_at',
        'deleted_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
