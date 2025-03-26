<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

abstract class Controller
{

    protected function uploadFile($file, $path = '')
    {
        try {
            $fileName = Str::random(16).'.'.$file->getClientOriginalExtension();
            // Save to the "public" disk under uploads/$path
            return $file->storeAs("public/uploads/$path", $fileName);
        } catch (\Exception $e) {
            report($e);
            return false;
        }
    }


    protected function deleteImage($relativePath)
    {
        try {
            if ($relativePath && Storage::exists($relativePath)) {
                return Storage::delete($relativePath);
            }
            return false;
        } catch (\Exception $e) {
            report($e);
            return false;
        }
    }

    /**
     * Convert relative path to URL when needed (e.g., for API responses)
     */
    protected function getFileUrl($relativePath)
    {
        return $relativePath ? Storage::url($relativePath) : null;
    }

    /**
     * Process icon string (base64 or URL)
     */

}
