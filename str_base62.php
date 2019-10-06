<?php

/* 62 進位制數字順序（同 ASCII） */
if (!defined('base62_dict'))
{
    define('base62_dict', '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz');
}

/* 產生隨機 Base62 字串 */
if (!function_exists('str_base62'))
{
    function str_base62($length = 8)
    {
        $str = '';
        for ($i = 0; $i < $length; $i++)
        {
            $rand = mt_rand(0, 61);
            $str .= base62_dict[$rand];
        }
        return $str;
    }
}