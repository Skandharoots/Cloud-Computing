<?php

namespace App\Helpers;

class FileHelper
{
    /**
     * Get the file extension from the given file name.
     *
     * @param string $fileName
     * @return string
     */
    public static function GetFileExtensionFromFileName(string $fileName): string
    {
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);

        return $extension;
    }
}
