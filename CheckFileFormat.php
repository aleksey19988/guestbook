<?php

function checkFileFormat(array $file): array
{
    $errors = [];
    $properties = $file['user-file'];
    if (isset($properties)) {
        $maxsize = 1000000;
        $acceptImageFormats = [
            'image/jpg',
            'image/gif',
            'image/png',
        ];
        if ($properties['size'] >= $maxsize || $properties['size'] == 0) {
            $errors[] = 'File too large. File must be less than 1 megabyte';
        }
        if (!in_array($properties['type'], $acceptImageFormats) && (!empty($properties['type']))) {
            $errors[] = 'Invalid file type. Only JPG, GIF and PNG types are accepted';
        }
    }

    return $errors;
}