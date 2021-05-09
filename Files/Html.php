<?php

if (!function_exists('TitleOnlyPage'))
{
    /**
     * 返回僅有 title 的空頁面 HTML 碼
     *
     * @param  string  $title  頁面標題
     * @return string
     */
    function TitleOnlyPage($title)
    {
        $html =
            "<!DOCTYPE html>\n" .
            "<html>\n" .
            "<head>\n" .
            "    <meta charset=\"utf-8\">\n" .
            "    <title>{$title}</title>\n" .
            "</head>\n" .
            "<body>\n" .
            "</body>\n" .
            "</html>";
        return $html;
    }
}
