<?php

if (!function_exists('VarExportFormat'))
{
    /**
     * 將變數轉為 PHP 程式碼字串並格式化
     *
     * @param  mixed  $var  待轉為 PHP 程式碼字串並格式化的變數
     * @return string
     */
    function VarExportFormat($var)
    {
        return preg_replace(
            [
                "/\n((?:  )+) *([^ ])/",
                '/array \(/',
                '/=> ?\n */'
            ],
            [
                "\n$1$1$2",
                'array(',
                '=> '
            ],
            var_export($var, true)
        );
    }
}
