<?php

namespace App\Services;

use GdImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageOptimizerService
{
    /**
     * Convert an uploaded image or base64 data to WebP format with low memory footprint and high compression.
     */
    public function convertToWebp(
        UploadedFile|string $file,
        string $directory = 'pengaduan/pelapor',
        int $maxDimension = 1280,
        int $quality = 75
    ): string {
        $sourceImage = null;
        $filePath = null;

        try {
            if ($file instanceof UploadedFile) {
                $filePath = $file->getRealPath();
                $binary = file_get_contents($filePath);
            } elseif (preg_match('/^data:image\/(\w+);base64,/', $file)) {
                $base64Data = substr($file, strpos($file, ',') + 1);
                $binary = base64_decode($base64Data);
            } else {
                $binary = $file;
            }

            if (! $binary) {
                throw new \InvalidArgumentException('Konten gambar kosong atau tidak valid.');
            }

            // Create GD image resource from string binary
            $sourceImage = @imagecreatefromstring($binary);
            unset($binary); // Free binary string from memory immediately

            if (! $sourceImage instanceof GdImage && ! is_resource($sourceImage)) {
                throw new \RuntimeException('GD tidak dapat memproses format gambar tersebut.');
            }

            // Auto-orient image based on EXIF metadata (mobile phone photos)
            if ($filePath && function_exists('exif_read_data')) {
                $exif = @exif_read_data($filePath);
                if (! empty($exif['Orientation'])) {
                    $sourceImage = match ((int) $exif['Orientation']) {
                        3 => imagerotate($sourceImage, 180, 0),
                        6 => imagerotate($sourceImage, -90, 0),
                        8 => imagerotate($sourceImage, 90, 0),
                        default => $sourceImage,
                    };
                }
            }

            $origWidth = imagesx($sourceImage);
            $origHeight = imagesy($sourceImage);

            // Compute optimal dimensions keeping aspect ratio (max dimension 1280px)
            if ($origWidth > $maxDimension || $origHeight > $maxDimension) {
                if ($origWidth >= $origHeight) {
                    $newWidth = $maxDimension;
                    $newHeight = (int) round(($origHeight / $origWidth) * $maxDimension);
                } else {
                    $newHeight = $maxDimension;
                    $newWidth = (int) round(($origWidth / $origHeight) * $maxDimension);
                }
            } else {
                $newWidth = $origWidth;
                $newHeight = $origHeight;
            }

            // Create resized canvas
            $targetImage = imagecreatetruecolor($newWidth, $newHeight);

            // Preserve alpha transparency
            imagealphablending($targetImage, false);
            imagesavealpha($targetImage, true);

            // Resample
            imagecopyresampled(
                $targetImage,
                $sourceImage,
                0, 0, 0, 0,
                $newWidth,
                $newHeight,
                $origWidth,
                $origHeight
            );

            // Destroy source image to release memory before encoding
            if ($sourceImage instanceof GdImage || is_resource($sourceImage)) {
                imagedestroy($sourceImage);
                $sourceImage = null;
            }

            // Capture WebP binary from buffer
            ob_start();
            imagewebp($targetImage, null, $quality);
            $webpData = ob_get_clean();

            // Destroy target image immediately
            if ($targetImage instanceof GdImage || is_resource($targetImage)) {
                imagedestroy($targetImage);
                $targetImage = null;
            }

            // Force garbage collection of memory buffers
            if (function_exists('gc_collect_cycles')) {
                gc_collect_cycles();
            }

            // Generate clean random filename and persist to public disk
            $filename = Str::random(40).'.webp';
            $relativePath = trim($directory, '/').'/'.$filename;

            Storage::disk('public')->put($relativePath, $webpData);
            unset($webpData);

            return $relativePath;

        } catch (\Throwable $e) {
            Log::warning('Konversi gambar ke WebP gagal, menggunakan fallback default: '.$e->getMessage());

            if ($sourceImage instanceof GdImage || is_resource($sourceImage)) {
                imagedestroy($sourceImage);
            }

            // Safe fallback if GD fails
            if ($file instanceof UploadedFile) {
                return $file->store($directory, 'public');
            }

            return $file;
        }
    }
}
