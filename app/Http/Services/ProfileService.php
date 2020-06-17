<?php

namespace App\Http\Services;

use Illuminate\Http\UploadedFile;

class ProfileService
{
    /**
     * Обработка загрузки картинки для аватара
     */
    public function handleUploadedImage(?UploadedFile $image): void
    {
        if (!is_null($image)) {
            user()->update(['avatar_path' => $image->store('public/images')]);
        }
    }

}
