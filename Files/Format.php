<?php

if (!defined('EmailFormat'))
{
    /**
     * 電子郵件信箱的格式正規表示法
     *
     * @var string
     */
    define('EmailFormat', '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD');
}

if (!function_exists('CheckYmdHis'))
{
    /**
     * 檢查時間字串是否為合法的 `Y-m-d H:i:s` 格式
     *
     * @param  string $TimeString 時間字串
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

if (!function_exists('SecondsToEnglishString'))
{
    /**
     * 將秒數轉換成秒、分、時或日等各種時間單位（英文）
     *
     * @param  integer $Seconds 秒數
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

if (!function_exists('ChineseWeekDate'))
{
    /**
     * 將指定日期轉為中文「Y 年 n 月 j 日」格式，並附帶星期日序
     *
     * @param  string   $Date   `strtotime()` 可辨識的日期字串，預設值為 `null` 即不填，則將自動代入現在時間
     * @param  boolean  $Gap    年月日部分數字與中文字之間是否加空格，預設為 `true`
     * @param  string   $Prefix 星期日序前綴，預設為 `x` 即「星期」，可改為 `z` 即「週」
     * @return string[]
     */
    function ChineseWeekDate($Date = null, $Gap = true, $Prefix = 'x')
    {
        if ($Date === null)
        {
            $Time = time();
        }
        else
        {
            $Time = strtotime($Date);
        }

        $Day = $Gap ? date('Y 年 n 月 j 日', $Time) : date('Y年n月j日', $Time);

        $WeekDay = date('w', $Time);
        switch ($WeekDay)
        {
            case 0:
                $ChineseWeekDay = '日';
                break;

            case 1:
                $ChineseWeekDay = '一';
                break;

            case 2:
                $ChineseWeekDay = '二';
                break;

            case 3:
                $ChineseWeekDay = '三';
                break;

            case 4:
                $ChineseWeekDay = '四';
                break;

            case 5:
                $ChineseWeekDay = '五';
                break;

            case 6:
                $ChineseWeekDay = '六';
                break;
        }

        switch (strtolower($Prefix))
        {
            case 'z':
                $ChineseWeekDay = '週' . $ChineseWeekDay;
                break;

            case 'x':
            default:
                $ChineseWeekDay = '星期' . $ChineseWeekDay;
                break;
        }

        return [ $Day, $ChineseWeekDay ];
    }
}
