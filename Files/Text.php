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

if (!function_exists('SumWord'))
{
    /**
     * 依 `A = 1`、`B = 2`、`C = 3` 的規則，加總計算一個全英文單字或句子的字母值
     *
     * 若單字或句子中包含數字，該數字將會一併被加總（依數字值）  
     * 若數字是相連的，則會被是為一個整體的整數來計算
     *
     * @param  string  $word  要計算的全英文單字或句子
     * @return integer
     */
    function SumWord($word = '')
    {
        $dict = ' abcdefghijklmnopqrstuvwxyz';

        $sum = 0;
        $num = 0;
        $numStr = '';

        $word = preg_replace('/[^a-z0-9]/', '', strtolower($word));
        for ($i = 0; $i < strlen($word); $i++)
        {
            if (strpos($dict, $word[$i]))
            {
                if ($numStr != '')
                {
                    $num = (int) $numStr;
                    $sum += $num;

                    $num = 0;
                    $numStr = '';
                }

                $sum += strpos($dict, $word[$i]);
            }
            else
            {
                if (is_numeric($word[$i]))
                {
                    $numStr .= $word[$i];
                }

                if ($i === strlen($word) - 1)
                {
                    $sum += (int) $numStr;
                }
            }
        }

        return $sum;
    }
}
