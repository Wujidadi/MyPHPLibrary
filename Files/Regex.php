<?php

if (!function_exists('CombineRegex'))
{
    /**
     * 輸入正規表示法字串陣列，輸出組合後的單一正規表示法字串
     *
     * @param array $segments
     * @return string
     */
    function CombineRegex($segments)
    {
        $combo = [];

        foreach ($segments as $reg)
        {
            $combo[] = preg_replace(['/^\//', '/\/$/'], '', $reg);
        }

        $combo = '/' . implode('|', $combo) . '/';

        return $combo;
    }
}
