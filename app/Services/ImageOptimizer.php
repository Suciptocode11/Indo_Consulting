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

        // 1. Fallback to native Laravel store if GD extension is not available
        if (!extension_loaded('gd') || !function_exists('imagecreatetruecolor')) {
            return $file->store($directory, $disk);
        }

        // 2. Read dimensions and MIME type
        $imageInfo = @getimagesize($originalPath);
        if ($imageInfo === false) {
            return $file->store($directory, $disk);
        }

        $mime   = $imageInfo['mime'];
        $width  = $imageInfo[0];
        $height = $imageInfo[1];

        // Map canonical extension from true MIME type
        $extension = match ($mime) {
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/gif'  => 'gif',
            'image/webp' => 'webp',
            default      => strtolower($file->getClientOriginalExtension()) ?: 'jpg',
        };

        // Formats handled by GD
        $supportedMimes = ['image/jpeg', 'image/png', 'image/gif'];
        if (function_exists('imagecreatefromwebp') && function_exists('imagewebp')) {
            $supportedMimes[] = 'image/webp';
        }

        if (!in_array($mime, $supportedMimes, true)) {
            return $file->store($directory, $disk);
        }

        $needsResize = $width > $maxWidth;

        // PNG & GIF are lossless with transparency.
        // If they don't need resizing, NEVER re-encode them through GD.
        // Storing them untouched guarantees 100% transparency preservation and zero quality loss.
        if (in_array($mime, ['image/png', 'image/gif']) && !$needsResize) {
            return $file->store($directory, $disk);
        }

        // WebP without resize: store as-is
        if ($mime === 'image/webp' && !$needsResize) {
            return $file->store($directory, $disk);
        }

        // JPEG: only process if resize or quality reduction is needed
        $needsQualityReduction = ($mime === 'image/jpeg') && ($quality < 100);
        if (!$needsResize && !$needsQualityReduction) {
            return $file->store($directory, $disk);
        }

        // 3. Load source image resource safely
        $source = match ($mime) {
            'image/jpeg' => @imagecreatefromjpeg($originalPath),
            'image/png'  => @imagecreatefrompng($originalPath),
            'image/gif'  => @imagecreatefromgif($originalPath),
            'image/webp' => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($originalPath) : null,
            default      => null,
        };

        if (!$source) {
            return $file->store($directory, $disk);
        }

        // 4. Calculate new dimensions and resize with full transparency support
        if ($needsResize) {
            $newWidth  = $maxWidth;
            $newHeight = (int) round($height * ($maxWidth / $width));
            $target    = imagecreatetruecolor($newWidth, $newHeight);

            if ($mime === 'image/png' || $mime === 'image/gif' || $mime === 'image/webp') {
                imagealphablending($target, false);
                imagesavealpha($target, true);

                $transparent = imagecolorallocatealpha($target, 0, 0, 0, 127);
                imagefilledrectangle($target, 0, 0, $newWidth, $newHeight, $transparent);

                imagealphablending($source, true);
            }

            imagecopyresampled($target, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($source);
            $source = $target;
        }

        // 5. Always ensure imagesavealpha is explicitly active before saving PNG / WebP
        if ($mime === 'image/png' || $mime === 'image/webp') {
            imagealphablending($source, false);
            imagesavealpha($source, true);
        } elseif ($mime === 'image/gif') {
            imagesavealpha($source, true);
        }

        // 6. Generate filename and save to storage
        $filename = bin2hex(random_bytes(16)) . '.' . $extension;
        $fullPath = Storage::disk($disk)->path($directory . '/' . $filename);

        $dirPath = dirname($fullPath);
        if (!is_dir($dirPath)) {
            mkdir($dirPath, 0755, true);
        }

        $success = match ($mime) {
            'image/jpeg' => imagejpeg($source, $fullPath, max(10, min(100, $quality))),
            'image/png'  => imagepng($source, $fullPath, 8),
            'image/gif'  => imagegif($source, $fullPath),
            'image/webp' => function_exists('imagewebp') ? imagewebp($source, $fullPath, max(10, min(100, $quality))) : false,
            default      => false,
        };

        imagedestroy($source);

        return $success ? $directory . '/' . $filename : $file->store($directory, $disk);
    }
}
