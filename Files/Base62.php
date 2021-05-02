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
     * 原名 `str_base62`
     *
     * @param  integer $length 字串長度
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

if (!function_exists('Base10To62'))
{
    /**
     * 將 10 進位數字轉成 62 進位數字
     *
     * @param  integer $num 10 進位數字
     * @return string
     */
    function Base10To62($num)
    {
        $to = 62;
        $ret = '';
        do {
            $ret = Base62Dict[bcmod($num, $to)] . $ret;
            $num = bcdiv($num, $to);
        } while ($num > 0);
        return $ret;
    }
}

if (!function_exists('Base62To10'))
{
    /**
     * 將 62 進位數字轉成 10 進位數字
     *
     * @param  integer $num 62 進位數字
     * @return string
     */
    function Base62To10($num)
    {
        $from = 62;
        $num = strval($num);
        $len = strlen($num);
        $dec = 0;
        for ($i = 0; $i < $len; $i++) {
            $pos = strpos(Base62Dict, $num[$i]);
            $dec = bcadd(bcmul(bcpow($from, $len - $i - 1), $pos), $dec);
        }
        return $dec;
    }
}
