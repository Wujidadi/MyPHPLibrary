<?php

if (!defined('EmailFormat'))
{
    /** 電子郵件信箱的格式正規表示法 */
    define('EmailFormat',
            // 前綴（Local name）
            '/^[\x20-\x21\x23-\x2d\x2f-\x3f\x41-\x5a\x5e-\x7e][\x20-\x21\x23-\x3f\x41-\x5a\x5e-\x7e]+[\x20-\x21\x23-\x2d\x2f-\x3f\x41-\x5a\x5e-\x7e]'
            // 小老鼠（At sign）
          . '@'
            // 後綴（Domain name）：至少一級域名
          . '[0-9A-Za-z][0-9A-Za-z\-\.]+\.'
          . '[0-9A-Za-z\-\.]+[0-9A-Za-z]$/');
}

if (!function_exists('RemoveTrailingZeros'))
{
    /**
     * 給定經格式化後的數字字串，去除小數點後的 0
     *
     * 應用於以 number_format() 加上千分位符號的數字
     *
     * @param string $strnum
     * @return string
     */
    function RemoveTrailingZeros($strnum)
    {
        return preg_replace(
            [
                '/\.0+$/',
                '/(\.\d*[^0])0+$/'
            ],
            [
                '',
                '$1'
            ],
            $strnum
        );
    }
}
