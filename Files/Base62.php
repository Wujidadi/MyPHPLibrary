<?php

if (!defined('Base62Dict'))
{
    /** 62 進位制數字順序（同 ASCII） */
    define('Base62Dict', '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz');
}

if (!function_exists('StrBase62'))
{
    /**
     * 產生隨機 Base62 字串
     *
     * 原名 str_base62
     *
     * @param integer $length
     * @return string
     */
    function StrBase62($length = 8)
    {
        $str = '';
        for ($i = 0; $i < $length; $i++)
        {
            $rand = mt_rand(0, 61);
            $str .= Base62Dict[$rand];
        }
        return $str;
    }
}
