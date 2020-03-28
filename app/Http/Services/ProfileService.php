<?php

namespace App\Http\Services;

use Illuminate\Http\UploadedFile;

class ProfileService
{
    public static function handleUploadedImage(?UploadedFile $image)
    {
        if (!is_null($image)) {
            user()->update(['avatar_path' => $image->store('public/images')]);
        }
    }
}
