<?php

namespace App\Helpers;

class ImageHelper
{
    public static function uploadAndResize($file, $directory, $fileName, $width = null, $height = null)
    {
        $destinationPath = public_path($directory);

        // Pastikan folder ada
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $mime = $file->getMimeType(); // Gunakan MIME type asli
        $image = null;

        // Buat image sesuai tipe file
        switch ($mime) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($file->getRealPath());
                break;
            case 'image/png':
                $image = imagecreatefrompng($file->getRealPath());
                break;
            case 'image/gif':
                $image = imagecreatefromgif($file->getRealPath());
                break;
            default:
                throw new \Exception('Unsupported image type: ' . $mime);
        }

        // Resize jika diminta
        if ($width) {
            $oldWidth = imagesx($image);
            $oldHeight = imagesy($image);
            $aspectRatio = $oldWidth / $oldHeight;

            if (!$height) {
                $height = $width / $aspectRatio;
            }

            $newImage = imagecreatetruecolor($width, $height);

            // Jika PNG, pertahankan transparansi
            if ($mime === 'image/png' || $mime === 'image/gif') {
                imagecolortransparent($newImage, imagecolorallocatealpha($newImage, 0, 0, 0, 127));
                imagealphablending($newImage, false);
                imagesavealpha($newImage, true);
            }

            imagecopyresampled($newImage, $image, 0, 0, 0, 0, $width, $height, $oldWidth, $oldHeight);
            imagedestroy($image);
            $image = $newImage;
        }

        // Simpan image
        switch ($mime) {
            case 'image/jpeg':
                imagejpeg($image, $destinationPath . '/' . $fileName, 90); // kualitas 90
                break;
            case 'image/png':
                imagepng($image, $destinationPath . '/' . $fileName);
                break;
            case 'image/gif':
                imagegif($image, $destinationPath . '/' . $fileName);
                break;
        }

        imagedestroy($image);
        return $fileName;
    }
}
