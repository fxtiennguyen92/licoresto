<?php

namespace App\Http\Common;


class ImageStorage
{
    public static function store(
        $imgSource,
        string $fileName,
        string $folderName,
        bool $convertWebp = false,
        string $currentFileName = null
    ) {
        # Define paths
        $path = public_path($folderName);
        $removePath = is_null($currentFileName) ? '' : public_path($currentFileName);

        # Save
        $imgSource->move($path, $fileName);
        $imageLink = $folderName . '/' . $fileName;

        # Remove
        if ($removePath) unlink($removePath);

        if ($convertWebp) {

        }

        return $imageLink;
    }

    public static function convertWebp()
    {
    }
}
