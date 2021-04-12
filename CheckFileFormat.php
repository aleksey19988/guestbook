<?php

function checkFileFormat(array $file): array
{
    $errors = [];
    $properties = $file['user-file'];
    $nameFileWithFormat = explode('.', $properties['name']);
    $fileFormat = $nameFileWithFormat[count($nameFileWithFormat) - 1];//Расширение проверяется не так, как следовало бы. Я понимаю. Но по-другоу не получилось
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
                $errors[] = 'Файл слишком тяжёлый. Его вес не может превышать 1 мегабайт';
            }
        } elseif (in_array($fileFormat, $acceptFormats['textFormats'])) {
            $maxsize = 100000;
            if ($properties['size'] >= $maxsize || $properties['size'] === 0) {
                $errors[] = 'File too large. File must be less than 1 megabyte';
            }
        } elseif ($properties['error'] == 4) {
            return $errors;
        } else {
            $errors[] = 'Неподходящий формат файла. Только JPG, GIF и PNG-форматы допускаются для картинок и только TXT-формат допускается для текстовых файлов';
        }
    }

    return $errors;
}