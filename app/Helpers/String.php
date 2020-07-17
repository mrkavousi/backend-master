<?php

// Cobvert English Numbers to Persian
function en_to_fa($string)
{
    $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
    $num = range(0, 9);

    return str_replace($num, $persian, $string);
}

// Cobvert Persian Numbers to English
function fa_to_en($string)
{
    $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
    $num = range(0, 9);

    return str_replace($persian, $num, $string);
}

function arabicToPersian($string)
{
    $characters = [
        'ك' => 'ک',
        'دِ' => 'د',
        'بِ' => 'ب',
        'زِ' => 'ز',
        'ذِ' => 'ذ',
        'شِ' => 'ش',
        'سِ' => 'س',
        'ى' => 'ی',
        'ي' => 'ی',
        '١' => '۱',
        '٢' => '۲',
        '٣' => '۳',
        '٤' => '۴',
        '٥' => '۵',
        '٦' => '۶',
        '٧' => '۷',
        '٨' => '۸',
        '٩' => '۹',
        '٠' => '۰',
    ];

    return str_replace(array_keys($characters), array_values($characters), $string);
}

function getCdnHostName($includeProtocol = false)
{
    return ($includeProtocol ? '//' : '') . env('CDN_SUBDOMAIN') . '.' . env('APP_DOMAIN') . '.' . env('APP_TLD');
}