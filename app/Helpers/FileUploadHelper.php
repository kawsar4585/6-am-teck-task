<?php
namespace App\Helpers;


class FileUploadHelper
{
    public static function getUploadPath()
    {
        return public_path('storage');
    }

}
