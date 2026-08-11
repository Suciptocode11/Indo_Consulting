<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageOptimizer
{
    /**
     * Compress and resize an uploaded image, then store it.
     * Returns the storage path. Preserves original format.
     */
    public static function optimizeAndStore(
        UploadedFile $file,
        string $directory,
        int $maxWidth = 1200,
        int $quality = 85,
        string $disk = 'public'
    ): string {
        $originalPath = $file->getRealPath();
        $imageInfo = @getimagesize($originalPath);

        if ($imageInfo === false) {
            return $file->store($directory, $disk);
        }

        $mime = $imageInfo['mime'];
        $width = $imageInfo[0];
        $height = $imageInfo[1];
        $extension = strtolower($file->getClientOriginalExtension());

        // Skip optimization for formats we can't handle
        if (!in_array($mime, ['image/jpeg', 'image/png', 'image/gif'])) {
            return $file->store($directory, $disk);
        }

        $needsResize = $width > $maxWidth;
        $needsQualityReduction = in_array($mime, ['image/jpeg', 'image/png']) && $quality < 100;

        if (!$needsResize && !$needsQualityReduction) {
            return $file->store($directory, $disk);
        }

        $source = match ($mime) {
            'image/jpeg' => imagecreatefromjpeg($originalPath),
            'image/png' => imagecreatefrompng($originalPath),
            'image/gif' => imagecreatefromgif($originalPath),
            default => null,
        };

        if ($source === null) {
            return $file->store($directory, $disk);
        }

        if ($needsResize) {
            $newWidth = $maxWidth;
            $newHeight = (int) round($height * ($maxWidth / $width));
            $resized = imagecreatetruecolor($newWidth, $newHeight);

            if ($mime === 'image/png' || $mime === 'image/gif') {
                imagealphablending($resized, false);
                imagesavealpha($resized, true);
                $transparent = imagecolorallocatealpha($resized, 0, 0, 0, 127);
                imagefilledrectangle($resized, 0, 0, $newWidth, $newHeight, $transparent);
            }

            imagecopyresampled($resized, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($source);
            $source = $resized;
        }

        $filename = bin2hex(random_bytes(16)) . '.' . $extension;
        $fullPath = Storage::disk($disk)->path($directory . '/' . $filename);

        $dirPath = dirname($fullPath);
        if (!is_dir($dirPath)) {
            mkdir($dirPath, 0755, true);
        }

        $success = match ($extension) {
            'jpg', 'jpeg' => imagejpeg($source, $fullPath, $quality),
            'png' => imagepng($source, $fullPath, (int) round((100 - $quality) / 10)),
            'gif' => imagegif($source, $fullPath),
            default => false,
        };

        imagedestroy($source);

        return $success ? $directory . '/' . $filename : $file->store($directory, $disk);
    }
}
