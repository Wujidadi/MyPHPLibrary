<?php

if (!function_exists('Blank'))
{
    /**
     * 產生指定數目的空格
     *
     * @param  integer  $Number  空格數目
     * @return string
     */
    function Blank($Number = 1)
    {
        $Blank = '';
        for ($i = 0; $i < $Number; $i++)
        {
            $Blank .= ' ';
        }
        return $Blank;
    }
}

if (!function_exists('TextCompress'))
{
    /**
     * 壓縮字串：刪除字串中的換行字元及多餘空格
     *
     * @param  string  $text  要壓縮的字串
     * @return string
     */
    function TextCompress($text = '')
    {
        return preg_replace([
            '/\r?\n */',
            '/\( +/', '/ +\)/',
            '/\[ +/', '/ +\]/',
            '/\{ +/', '/ +\}/'
        ], [
            ' ',
            '(', ')',
            '[', ']',
            '{', '}'
        ], $text);
    }
}

if (!function_exists('RemoveTrailingZeros'))
{
    /**
     * 給定經格式化後的數字字串，去除小數點後的 0
     *
     * 應使用於以 `number_format()` 加上千分位符號的數字
     *
     * @param  string  $strnum  格式化數字字串
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
