<?php

if (!function_exists('JsonUnscaped'))
{
    /**
     * 返回 UTF-8 編碼、Unicode 及反斜線不轉義的 JSON 資料
     *
     * @param array|object $data
     * @return string
     */
    function JsonUnscaped($data)
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
