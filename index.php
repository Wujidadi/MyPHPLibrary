<?php

header('content-type: text/plain');

$mode = $_GET['mode'] ?? 'combo';

// 正規表示法陣列測試
$regSeg = [
    '/^\/favicon\.(?:png|ico)$/',
    '/^\/css\//',
    '/\.css$/',
    '/^\/js\//',
    '/\.js$/',
    '/^\/lib\//',
    '/^\/storage\//',
    '/\/*manifest\.json$/'
];

switch (strtolower($mode))
{
    case 'combo':
    case 'combine':
    case 'combination':
    {
        require_once 'test_combo.php';
        break;
    }

    case 'obj':
    case 'object':
    case 'class':
    {
        require_once 'test_obj.php';
        break;
    }
}
