<?php

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
