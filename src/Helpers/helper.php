<?php
/**
 * Created by PhpStorm.
 * User: Sarfraz
 * Date: 8/13/2018
 * Time: 1:01 PM
 */

if (!function_exists('noty')) {
    function noty($message, $type = '', array $options = [])
    {
        $type = $type ?: config('noty.type');
        $type = $type ?: 'info';

        $noty = app('noty');

        return $noty->notify($message, $type, $options);
    }
}

if (!function_exists('extractQuoted')) {
    function extractQuoted(array $array)
    {
        $string = '';

        foreach ($array as $value) {
            $string .= "'$value',";
        }

        return rtrim($string, ',');
    }
}
