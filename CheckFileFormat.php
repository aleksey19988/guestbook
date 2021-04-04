<?php

function checkFileFormat(array $file): array
{
    $errors = [];
    $properties = $file['user-file'];
    $nameFileWithFormat = explode('.', $properties['name']);
    $fileFormat = $nameFileWithFormat[count($nameFileWithFormat) - 1];
    $acceptFormats = [
        'imageFormats' => [
            'jpg',
            'gif',
            'png',
        ],
        'textFormats' => [
            'txt',
        ],
    ];
    if (isset($properties)) {
        if (in_array($fileFormat, $acceptFormats['imageFormats'])) {
            $maxsize = 1000000;
            if ($properties['size'] >= $maxsize || $properties['size'] === 0) {
                $errors[] = 'File too large. File must be less than 1 megabyte';
            }
        } elseif (in_array($fileFormat, $acceptFormats['textFormats'])) {
            $maxsize = 100000;
            if ($properties['size'] >= $maxsize || $properties['size'] === 0) {
                $errors[] = 'File too large. File must be less than 1 megabyte';
            }
        } elseif ($properties['error'] == 4) {
            return $errors;
        } else {
            $errors[] = 'Invalid file type. Only JPG, GIF and PNG types are accepted for images and only TXT type are accepted for text files';
        }
    }

    return $errors;
}