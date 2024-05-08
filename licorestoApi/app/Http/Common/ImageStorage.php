<?php

namespace App\Http\Common;

use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager;

class ImageStorage
{
    /**
     * Store image
     */
    public static function store(
        $imgSource,
        string $fileName,
        string $folderName,
        bool $convertWebp = false,
        string $currentFileName = null
    ) {
        try {
            # Define paths
            $folderPath = public_path($folderName);
            $removePath = is_null($currentFileName) ? '' : public_path($currentFileName);

            # Save
            $imgSource->move($folderPath, $fileName);


            # Remove
            if ($removePath) unlink($removePath);

            # Convert to webp
            if ($convertWebp) {
                $filePath = $folderName . '/' . $fileName;
                $covertedFile = ImageStorage::convertWebp($filePath);

                # Return coverted file path if convert successfully
                if ($covertedFile !== false) {
                    return $covertedFile;
                }
            }

            # Return file path
            $savedFile = $folderName . '/' . $fileName;
            return $savedFile;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Convert image to webp
     */
    public static function convertWebp(string $filePath)
    {
        $inputPath = public_path($filePath);

        $outputFile = preg_replace('/\..+$/', '.webp', $filePath); // change extension to .webp
        $outputPath = public_path($outputFile);

        try {
            $manager = new ImageManager(Driver::class);

            $image = $manager->read($inputPath);
            $image->encode(new WebpEncoder(quality: 65));

            $image->save($outputPath);
            unlink($inputPath);

            return $outputFile;
        } catch (\Exception $e) {
            return false;
        }
    }
}
