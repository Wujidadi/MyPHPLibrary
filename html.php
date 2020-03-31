<?php

/* 指定命名空間並引入 Helpers class */
// namespace App; require_once('Classes/Helpers.php');
// use App\Classes\Helpers as Helpers;

/* 引入各個分開的檔案 */
require_once('Files/Html.php');

echo TitleOnlyPage('HTML 空頁面測試');

// echo Helpers::TitleOnlyPage('HTML 空頁面測試');
