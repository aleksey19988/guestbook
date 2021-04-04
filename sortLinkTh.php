<?php

function sortLinkTh(string $header, string $directOrder, string $reverseOrder): string
{
    if (count($_GET) === 0 || !isset($_GET['sort'])) {
        $order = '';
    } else {
        $order = $_GET['sort'];
    }

    if ($order === $directOrder) {
        return '<a href="?sort=' . $reverseOrder . '" class="header_link">' . $header . '<span>&#9650;</span></a>';
    } elseif ($order === $reverseOrder) {
        return '<a href="?sort=' . $directOrder . '" class="header_link">' . $header . '<span>&#9660;</span></a>';
    } else {
        return '<a href="?sort=' . $directOrder . '" class="header_link">' . $header . '</a>';
    }
}