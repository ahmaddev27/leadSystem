<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

abstract class Controller
{

    protected function uploadFile($file, $path = '')
    {
        try {
            $fileName = Str::random(16).'.'.$file->getClientOriginalExtension();
            // Save to the "public" disk under uploads/$path
            return $file->storeAs("/uploads/$path", $fileName);
        } catch (\Exception $e) {
            report($e);
            return false;
        }
    }


    protected function deleteImage($relativePath)
    {
        // Skip if no path provided
        if (empty($relativePath)) {
            return false;
        }

        try {
            // Check if file exists
            if (!Storage::exists($relativePath)) {
                return true; // Considered successful if file doesn't exist
            }

            // Delete the file
            if (Storage::delete($relativePath)) {
                return true;
            }

            Log::error("Failed to delete image (storage error): {$relativePath}");
            return false;

        } catch (\Exception $e) {
            Log::error("Image deletion exception: {$relativePath} - " . $e->getMessage());
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
