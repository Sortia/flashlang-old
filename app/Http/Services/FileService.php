<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileService
{
    /**
     * Save file from string
     */
    public function save(string $file, $path = 'public/images/', $extension = '.jpg'): string
    {
        $filename = $path . Str::random(40) . $extension;

        Storage::put($filename, $file);

        return $filename;
    }
}
