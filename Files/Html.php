<?php

if (!function_exists('TitleOnlyPage'))
{
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
