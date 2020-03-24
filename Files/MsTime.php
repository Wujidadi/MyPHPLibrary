<?php

if (!function_exists('MsTime'))
{
    /**
     * 返回微秒級時間字串
     *
     * @return string
     */
    function MsTime()
    {
        $datetime = new \DateTime();
        $time = $datetime->format('Y-m-d H:i:s.u');
        return $time;
    }
}

if (!function_exists('MsTimestamp'))
{
    /**
     * 返回微秒級時間戳
     *
     * @return string
     */
    function MsTimestamp()
    {
        $time = explode(' ', microtime());
        $s = $time[1];
        $ms = rtrim($time[0], '0');
        $ms = preg_replace('/^0/', '', $ms);
        $mtime = $s . $ms;
        return $mtime;
    }
}
