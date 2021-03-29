<?php

function sortLinkTh($header, $directOrder, $reverseOrder)
{
    $order = $_GET['sort'];

    if ($order === $directOrder) {
        return '<a href="?sort=' . $reverseOrder . '" class="header_link">' . $header . '<span>&#9660;</span></a>';
    } elseif ($order === $reverseOrder) {
        return '<a href="?sort=' . $directOrder . '" class="header_link">' . $header . '<span>&#9650;</span></a>';
    } else {
        return '<a href="?sort=' . $directOrder . '" class="header_link">' . $header . '</a>';
    }
}