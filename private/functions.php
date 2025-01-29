<?php

function urlFor(string $script_path): string 
{
    // add the leading '/' if not present
    if($script_path[0] !== '/') {
        $script_path = '/' . $script_path;
    }
    return WWW_ROOT . $script_path;
}

function u(string $string=''): string 
{
    return urlencode($string);
}

function rawU(string $string=''): string 
{
    return rawurlencode($string);
}

function h(string $string=''): string 
{
    return htmlspecialchars($string);
}

function error_404() {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    exit;
}

function error_500() {
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error');
    exit;
}

function formatMoney(float $amount): string
{
    return '$' . number_format($amount, 2);
}