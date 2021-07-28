<?php

namespace App\Services;

class UtilsServices{
    static function slugify(string $text):string
    {
    // replace non letter or digits by -
    $text = preg_replace('#[^\\p­L\d]+#u', '-', $text);

    // trim
    $text = trim($text, '-');

    // transliterate
    if (function_exists('ic­onv')){
    $text = iconv('utf-8', 'us-ascii//­TRANSLIT', $text);
    }

    // lowercase
    $text = strtolower($text);

    // remove unwanted characters
    $text = preg_replace('#[^-\w­]+#', '', $text);

    if (empty($text)) {
    return 'n-a';
    }

    return $text;
    }
}