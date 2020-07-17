<?php

function percent_to_decimal($number)
{
    return str_replace('%', '', $number) / 100;
}

// Format Big Numbers Like 99K+
function number_format_short($n)
{
    if ($n > 0 && $n < 1000) {
        // 1 - 999
        $n_format = floor($n);
        $suffix = '';
    } else if ($n >= 1000 && $n < 1000000) {
        // 1k-999k
        $n_format = floor($n / 1000);
        $suffix = 'K+';
    } else if ($n >= 1000000 && $n < 1000000000) {
        // 1m-999m
        $n_format = floor($n / 1000000);
        $suffix = 'M+';
    } else if ($n >= 1000000000 && $n < 1000000000000) {
        // 1b-999b
        $n_format = floor($n / 1000000000);
        $suffix = 'B+';
    } else if ($n >= 1000000000000) {
        // 1t+
        $n_format = floor($n / 1000000000000);
        $suffix = 'T+';
    }

    return !empty($n_format . $suffix) ? $n_format . $suffix : 0;
}

// Detect Mobile Number
function isMobile($number)
{
    $number = fa_to_en($number);
    $pattern = '/(0|\+98)?([ ]|-|[()]){0,2}9[0-9]([ ]|-|[()]){0,2}(?:[0-9]([ ]|-|[()]){0,2}){7}/';
    if (preg_match($pattern, $number) && strlen($number) == 11)
        return true;

    return false;
}

// Format Mobile Number
function format_mobile($number)
{
    if (substr($number, 0, 3) == '+98')
        return $number;
    if (substr($number, 0, 2) == '09')
        return '+98' . substr($number, 1, 10);
    if (substr($number, 0, 2) == '98')
        return '+' . $number;
    if (substr($number, 0, 1) == '9')
        return '+98' . $number;
}