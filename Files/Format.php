<?php

if (!defined('EmailFormat'))
{
    /** 電子郵件信箱的格式正規表示法 */
    define('EmailFormat',
            // 前綴（Local name）
            '/^[\x20-\x21\x23-\x2d\x2f-\x3f\x41-\x5a\x5e-\x7e][\x20-\x21\x23-\x3f\x41-\x5a\x5e-\x7e]*[\x20-\x21\x23-\x2d\x2f-\x3f\x41-\x5a\x5e-\x7e]'
            // 小老鼠（At sign）
          . '@'
            // 後綴（Domain name）：至少一級域名
          . '[0-9A-Za-z][0-9A-Za-z\-\.]+\.'
          . '[0-9A-Za-z\-\.]+[0-9A-Za-z]$/');
}

if (!function_exists('SecondsToEnglishString'))
{
    /**
     * 將秒數轉換成秒、分、時或日等各種時間單位（英文）
     *
     * @param integer $Seconds
     * @return string|null
     */
    function SecondsToEnglishString($Seconds)
    {
        $Second = $Seconds % 60;
        $Minute = ($Seconds - $Second) / 60 % 60;
        $Hour = (($Seconds - $Second) / 60 / 60) % 24;
        $Day = (($Seconds - $Second) / 60 / 60 / 24) % 7;
        $Week = floor(($Seconds - $Second) / 60 / 60 / 24 / 7);
        
        $Array = [];

        // Week
        if ($Week > 1)
        {
            $Array[] = $Week . ' weeks';
        }
        else if ($Week > 0)
        {
            $Array[] = $Week . ' week';
        }

        // Day
        if ($Day > 1)
        {
            $Array[] = $Day . ' days';
        }
        else if ($Day > 0)
        {
            $Array[] = $Day . ' day';
        }

        // Hour
        if ($Hour > 1)
        {
            $Array[] = $Hour . ' hours';
        }
        else if ($Hour > 0)
        {
            $Array[] = $Hour . ' hour';
        }

        // Minute
        if ($Minute > 1)
        {
            $Array[] = $Minute . ' minutes';
        }
        else if ($Minute > 0)
        {
            $Array[] = $Minute . ' minute';
        }

        // Second
        if ($Second > 1)
        {
            $Array[] = $Second . ' seconds';
        }
        else if ($Second > 0)
        {
            $Array[] = $Second . ' second';
        }

        $String = implode(', ', $Array);
        $String = preg_replace('/, ([^,]+)$/', ' and $1', $String);

        return $String;
    }
}

if (!function_exists('CheckYmdHis'))
{
    /**
     * 檢查時間字串是否為合法的 `Y-m-d H:i:s` 格式
     *
     * @param string $TimeString
     * @return boolean
     */
    function CheckYmdHis($TimeString)
    {
        $TimeFormat = '/^\d{1,}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/';

        if (!preg_match($TimeFormat, $TimeString))
        {
            return false;
        }
        else
        {
            $FullArray = explode(' ', $TimeString);
            $Date = $FullArray[0];
            $Time = $FullArray[1];

            $DateArray = explode('-', $Date);
            $Year  = (int) $DateArray[0];
            $Month = (int) $DateArray[1];
            $Day   = (int) $DateArray[2];

            $TimeArray = explode(':', $Time);
            $Hour   = (int) $TimeArray[0];
            $Minute = (int) $TimeArray[1];
            $Second = (int) $TimeArray[2];

            if (($Month < 1 || $Month > 12) ||
                ($Day < 1) ||
                (in_array($Month, [1, 3, 5, 7, 8, 10, 12]) && $Day > 31) ||
                (in_array($Month, [4, 6, 9, 11]) && $Day > 30) ||
                ($Month === 2 && $Day > 29) ||
                ($Hour < 0 || $Hour > 23) ||
                ($Minute < 0 || $Minute > 59) ||
                ($Second < 0 || $Second > 59))
            {
                return false;
            }
            else
            {
                return true;
            }
        }
    }
}
