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

if (!function_exists('JsonEmptyObject'))
{
    /**
     * 將 JSON 字串中的「"{}"」兩側的雙引號去除，使成為標準的 JSON 空物件
     *
     * @param string $json
     * @return string
     */
    function JsonEmptyObject($json)
    {
        return preg_replace('/\"\{\}\"/', '{}', $json);
    }
}
