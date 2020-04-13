<?php

if (!function_exists('JsonUnescaped'))
{
    /**
     * 返回 UTF-8 編碼、Unicode 及反斜線不轉義的 JSON 資料
     *
     * @param array|object $data
     * @return string
     */
    function JsonUnescaped($data)
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}

if (!function_exists('JsonPrettyPrinted'))
{
    /**
     * 返回 UTF-8 編碼、Unicode 及反斜線不轉義且格式化的 JSON 資料
     *
     * @param array|object $data
     * @return string
     */
    function JsonPrettyPrinted($data)
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }
}
