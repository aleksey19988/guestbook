<?php

function checkFileFormat(array $file): array
{
    $properties = $file['user_file'];
    $size = $properties['size'];
    $sizeInMb = round($size / 1000000, 2);
    $result = array();
    if ($size === 0) {
        $result['result'] = 'success';
        return $result;
    }
    $nameFileWithFormat = explode('.', $properties['name']);
    $fileFormat = $nameFileWithFormat[count($nameFileWithFormat) - 1];//Формат(расширение) проверяется не так, как следовало бы. Я понимаю. Но по-другоу не получилось
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
        $result['properties'] = $properties;
        if (in_array($fileFormat, $acceptFormats['imageFormats'])) {
            $maxsize = 1000000;
            if ($properties['size'] >= $maxsize) {
                $result['result'] = "Изображение слишком тяжёлое. Его вес не может превышать 1 мегабайт (размер вашего файла: {$sizeInMb} мегабайт)";
            } else {
                $result['result'] = 'success';
            }
        } elseif (in_array($fileFormat, $acceptFormats['textFormats'])) {
            $maxsize = 100000;
            if ($properties['size'] >= $maxsize) {
                $result['result'] = 'Текстовый файл слишком тяжёлый. Его вес не может превышать 100 килобайт';
            } else {
                $result['result'] = 'success';
            }
        } else {
            $result['result'] = 'Неподходящий формат файла. Только JPG, GIF и PNG-форматы допускаются для картинок и только TXT-формат допускается для текстовых файлов';
        }
    } else {
        $result['result'] = 'success';
    }

    return $result;
}