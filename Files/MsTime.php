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
     * 返回當下的微秒級時間戳；有指定時間字串時，返回該字串的時間戳
     *
     * @param string|null $TimeString
     * @return float
     */
    function MsTimestamp($TimeString = null)
    {
        if (!is_null($TimeString))
        {
            $time = explode('+', $TimeString);
            $time = explode('.', $time[0]);
            $s = strtotime($time[0]);
            $ms = $time[1] ?? '000000';
            $mtime = $s . '.' . $ms;
        }
        else
        {
            $time = explode(' ', microtime());
            $s = $time[1];
            $ms = rtrim($time[0], '0');
            $ms = preg_replace('/^0/', '', $ms);
            $mtime = $s . $ms;
        }
        return (float) $mtime;
    }
}
