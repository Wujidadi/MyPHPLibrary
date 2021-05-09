<?php

namespace App\Classes;

/*
 *========================================
 * 目錄
 *========================================
 *
 * + 變數檢驗
 *   - function  IsSafe
 *
 * + 時間
 *   - function  Time
 *   - function  Timestamp
 *
 * + 數字及文字格式
 *   - const     EmailFormat
 *   - function  CheckYmdHis
 *   - function  SecondsToEnglishString
 *   - function  ChineseWeekDate
 *
 * + Excel 欄位名稱與數字互轉（變相的 26 進位）
 *   - function  ExcelColumnToNumber
 *   - function  NumberToExcelColumn
 *
 * + 文字及字元和字串處理
 *   - function  Blank
 *   - function  RemoveTrailingZeros
 *
 * + 正規表示法
 *   - function  CombineRegex
 *
 * + Base62
 *   - const     Base62Dict
 *   - function  StrBase62
 *   - function  Base10To62
 *   - function  Base62To10
 *
 * + GUID 與 UUID
 *   - function  Guid
 *   - function  Uuid
 *
 * + TGUID
 *   - function  Tguid16
 *   - function  Base62Guid
 *   - function  Base62Tguid
 *   - function  Tguid
 *   - function  TguidToTime
 *   - function  TimeToBase62Guid
 *
 * + JSON
 *   - function  JsonUnescaped
 *   - function  JsonPrettyPrinted
 *   - function  JsonEmptyObject
 *
 * + HTML
 *   - function  TitleOnlyPage
 *
 * + Cache Buster（防止前端資源快取）
 *   - function  AssetCachebuster
 *   - const     CachebusterLength
 *
 */

class Helpers
{
    /**
     * 檢查輸入值是否存在、不為 `null`、`false` 或空字串，返回 `true` 或 `false`
     * 
     * 0、字元 0（`'0'`）及空陣列或空物件視為 `true`
     *
     * `$value` 為未定義變數時會有警告（無法完全替代 `isset()` 的功能），可搭配 `@` 字元隱藏警告
     *
     * @param  integer|string|array|object  $value  輸入值
     * @return boolean
     */
    static public function IsSafe($value = null)
    {
        switch (true)
        {
            case ($value !== null && $value != null):
            case ($value !== null && $value === 0):
            case ($value !== null && $value === '0'):
            case ($value !== null && $value == null && is_array($value)):
                return true;

            default:
                return false;
        }
    }

    /**
     * 返回微秒級時間字串；有指定時間戳時，返回時間戳對應的時間字串
     *
     * @param  string|integer|double|null  $Timestamp  時間戳
     * @return string
     */
    static public function Time($Timestamp = null)
    {
        if ($Timestamp !== null)
        {
            $Timestamp = (string) $Timestamp;
            $date = explode('.', $Timestamp);
            $s = (int) $date[0];
            $ms = isset($date[1]) ? rtrim($date[1], '0') : '0';
            $time = ($ms != 0) ? date('Y-m-d H:i:s', $s) . '.' . $ms : date('Y-m-d H:i:s', $s);
            return $time;
        }
        else
        {
            $datetime = new \DateTime();
            $time = $datetime->format('Y-m-d H:i:s.u');
            return $time;
        }
    }

    /**
     * 返回當下的微秒級時間戳；有指定時間字串時，返回該字串的時間戳
     *
     * @param  string|null  $TimeString  時間字串
     * @return double
     */
    static public function Timestamp($TimeString = null)
    {
        if ($TimeString !== null)
        {
            $time = explode('+', $TimeString);
            $time = explode('.', $time[0]);
            $s = strtotime($time[0]);
            $ms = isset($time[1]) ? rtrim($time[1], '0') : '0';
            $mtime = ($ms != 0) ? ($s . '.' . $ms) : $s;
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

    /**
     * 電子郵件信箱的格式正規表示法
     *
     * @var string
     */
    const EmailFormat = '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD';

    /**
     * 檢查時間字串是否為合法的 `Y-m-d H:i:s` 格式
     *
     * @param  string  $TimeString  時間字串
     * @return boolean
     */
    static public function CheckYmdHis($TimeString)
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

    /**
     * 將秒數轉換成秒、分、時或日等各種時間單位（英文）
     *
     * @param  integer  $Seconds  秒數
     * @return string|null
     */
    static public function SecondsToEnglishString($Seconds)
    {
        $Second = $Seconds % 60;
        $Minute = ($Seconds - $Second) / 60 % 60;
        $Hour = (($Seconds - $Second) / 60 / 60) % 24;
        $Day = (($Seconds - $Second) / 60 / 60 / 24) % 7;
        $Week = floor(($Seconds - $Second) / 60 / 60 / 24 / 7);

        $Array = [];

        # Week
        if ($Week > 1)
        {
            $Array[] = $Week . ' weeks';
        }
        else if ($Week > 0)
        {
            $Array[] = $Week . ' week';
        }

        # Day
        if ($Day > 1)
        {
            $Array[] = $Day . ' days';
        }
        else if ($Day > 0)
        {
            $Array[] = $Day . ' day';
        }

        # Hour
        if ($Hour > 1)
        {
            $Array[] = $Hour . ' hours';
        }
        else if ($Hour > 0)
        {
            $Array[] = $Hour . ' hour';
        }

        # Minute
        if ($Minute > 1)
        {
            $Array[] = $Minute . ' minutes';
        }
        else if ($Minute > 0)
        {
            $Array[] = $Minute . ' minute';
        }

        # Second
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

    /**
     * 將指定日期轉為中文「Y 年 n 月 j 日」格式，並附帶星期日序
     *
     * @param  string    $Date    `strtotime()` 可辨識的日期字串，預設值為 `null` 即不填，則將自動代入現在時間
     * @param  boolean   $Gap     年月日部分數字與中文字之間是否加空格，預設為 `true`
     * @param  string    $Prefix  星期日序前綴，預設為 `x` 即「星期」，可改為 `z` 即「週」
     * @return string[]
     */
    static public function ChineseWeekDate($Date = null, $Gap = true, $Prefix = 'x')
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

    /**
     * 將 Excel A1 參照樣式中的欄位序號轉為數字（Office 2019 的最大值為 XFD = 16384）
     *
     * @param  string  $Column  欄位序號
     * @return integer|boolean
     */
    static public function ExcelColumnToNumber($Column)
    {
        $ColumnChar = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $Number = 0;

        $Column = strtoupper($Column);

        for ($i = 0; $i < strlen($Column); $i++)
        {
            if (strpos($ColumnChar, $Column[$i]) !== false)
            {
                $Digit = strlen($Column) - $i - 1;
                $Value = (strpos($ColumnChar, $Column[$i]) + 1) * pow(26, $Digit);
                $Number += $Value;
            }
            else
            {
                return false;
            }
        }

        return ($Number > 0) ? $Number : false;
    }

    /**
     * 將數字轉為 Excel A1 參照樣式中的欄位序號（Office 2019 的最大值為 XFD = 16384）
     *
     * @param  integer  $Number  欄位序數
     * @return string
     */
    static public function NumberToExcelColumn($Number)
    {
        $ColumnChar = 'ZABCDEFGHIJKLMNOPQRSTUVWXY';
        $Column = '';
        $LowDigitValue = '';    // 記錄前一位數的字母值

        $Digit = 0;             // 位數序，由右至左

        do
        {
            # 個位數的處理
            if ($Digit === 0)
            {
                $Remainder = $Number % 26;                // 對 26 取餘數
                $Quotient = (int) floor($Number / 26);    // 除 26 求商數
                $Value = $ColumnChar[$Remainder];         // 依餘數取得本位數的字母值
                $Column = $Value;                         // 將當前字母值填入 Column

                $LowDigitValue = $Value;                  // 將字母值存為前一位數字母值
                $Number = $Quotient;                      // 以本位數計算的商數取代原 Number

                $Digit++;                                 // 位數序進 1
            }
            # 十位數（第 2 位數）以上的處理
            else
            {
                if ($LowDigitValue === 'Z')
                {
                    $Number--;                            // 若前一位數字母值為 Z，則令 Number 退 1
                }
                $Remainder = $Number % 26;                // 對 26 取餘數
                $Quotient = (int) floor($Number / 26);    // 除 26 求商數
                $Value = $ColumnChar[$Remainder];         // 依餘數取得本位數的字母值

                if ($Quotient === 0 && $LowDigitValue === 'Z' && $Value === 'Z')
                {
                    # 商數為 0（最高位數）且前一位數字母值為 Z（不可進位）時，不將字母值添加到 Column
                }
                else
                {
                    $Column = $Value . $Column;           // 反之才將字母值添加到 Column
                }

                $LowDigitValue = $Value;                  // 將字母值存為前一位數字母值
                $Number = $Quotient;                      // 以本位數計算的商數取代原 Number

                $Digit++;                                 // 位數序進 1
            }
        }
        while ($Number > 0);

        return $Column;
    }

    /**
     * 產生指定數目的空格
     *
     * @param  integer  $Number  空格數目
     * @return string
     */
    static public function Blank($Number = 1)
    {
        $Blank = '';
        for ($i = 0; $i < $Number; $i++)
        {
            $Blank .= ' ';
        }
        return $Blank;
    }

    /**
     * 給定經格式化後的數字字串，去除小數點後的 0
     *
     * 應使用於以 `number_format()` 加上千分位符號的數字
     *
     * @param  string  $strnum  格式化數字字串
     * @return string
     */
    static public function RemoveTrailingZeros($strnum)
    {
        return preg_replace(
            [
                '/\.0+$/',
                '/(\.\d*[^0])0+$/'
            ],
            [
                '',
                '$1'
            ],
            $strnum
        );
    }

    /**
     * 輸入正規表示法字串陣列，輸出組合後的單一正規表示法字串
     *
     * @param  string[]  $segments  正規表示法字串陣列
     * @return string
     */
    static public function CombineRegex($segments)
    {
        $combo = [];

        foreach ($segments as $reg)
        {
            $combo[] = preg_replace(['/^\//', '/\/$/'], '', $reg);
        }

        $combo = '/' . implode('|', $combo) . '/';

        return $combo;
    }

    /**
     * 62 進位制數字順序（同 ASCII）
     *
     * @var string
     */
    const Base62Dict = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    /**
     * 返回隨機 Base62 字串
     *
     * 原名 `str_base62`
     *
     * @param  integer  $length  字串長度
     * @return string
     */
    static public function StrBase62($length = 8)
    {
        $str = '';
        for ($i = 0; $i < $length; $i++)
        {
            $rand = mt_rand(0, 61);
            $str .= self::Base62Dict[$rand];
        }
        return $str;
    }

    /**
     * 將 10 進位數字轉成 62 進位數字
     *
     * @param  integer  $num  10 進位數字
     * @return string
     */
    static public function Base10To62($num)
    {
        $to = 62;
        $ret = '';
        do
        {
            $ret = self::Base62Dict[bcmod($num, $to)] . $ret;
            $num = bcdiv($num, $to);
        }
        while ($num > 0);
        return $ret;
    }

    /**
     * 將 62 進位數字轉成 10 進位數字
     *
     * @param  integer  $num  62 進位數字
     * @return string
     */
    static public function Base62To10($num)
    {
        $from = 62;
        $num = strval($num);
        $len = strlen($num);
        $dec = 0;
        for ($i = 0; $i < $len; $i++)
        {
            $pos = strpos(self::Base62Dict, $num[$i]);
            $dec = bcadd(bcmul(bcpow($from, $len - $i - 1), $pos), $dec);
        }
        return $dec;
    }

    /**
     * 返回 GUID
     *
     * 原作者 Sujip Thapa (https://github.com/sudiptpa/guid)
     *
     * @param  boolean  $trim  是否去除頭尾的大括號
     * @return string
     */
    static public function Guid($trim = true)
    {
        # Windows
        if (function_exists('com_create_guid') === true) {
            if ($trim === true)
            {
                return trim(com_create_guid(), '{}');
            }
            else
            {
                return com_create_guid();
            }
        }

        # OSX/Linux
        if (function_exists('openssl_random_pseudo_bytes') === true)
        {
            $data = openssl_random_pseudo_bytes(16);
            $data[6] = chr(ord($data[6]) & 0x0f | 0x40);    // set version to 0100
            $data[8] = chr(ord($data[8]) & 0x3f | 0x80);    // set bits 6-7 to 10
            return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
        }

        # Fallback (PHP 4.2+)
        mt_srand((double) microtime() * 10000);
        $charid = strtolower(md5(uniqid(rand(), true)));
        $hyphen = chr(45);                                  // "-"
        $lbrace = $trim ? "" : chr(123);                    // "{"
        $rbrace = $trim ? "" : chr(125);                    // "}"
        $guidv4 = $lbrace .
        substr($charid, 0, 8) . $hyphen .
        substr($charid, 8, 4) . $hyphen .
        substr($charid, 12, 4) . $hyphen .
        substr($charid, 16, 4) . $hyphen .
        substr($charid, 20, 12) . $rbrace;

        return $guidv4;
    }

    /**
     * 將 PHP 內建函數 `uniqid()` 產生的 ID（不含熵）直接插入到 GUID 前面，並把被擠出去的原 GUID 字元刪除，維持 32 位數，並保留連字號
     *
     * @return string
     */
    static public function Uuid()
    {
        $unid = uniqid() . str_replace('-', '', self::Guid());
        $uuid = substr($unid, 0, 8) . '-' . substr($unid, 8, 4) . '-' . substr($unid, 12, 4) . '-' . substr($unid, 16, 4) . '-' . substr($unid, 20, 12);
        return $uuid;
    }

    /**
     * 產生 16 進位 GUID，再將 `uniqid()` 產生的 ID（含熵）插入 GUID 前面，並以連字號相連；整個字串長達 14 + 8 + 32 = 54 位數，含連字號為 60 位數
     *
     * @return string
     */
    static public function Tguid16()
    {
        $entropicGuid = str_replace('.', '-', uniqid('', true)) . '-' . self::Guid();
        return $entropicGuid;
    }

    /**
     * 將 16 進位的 GUID 轉為 62 進位；轉換完畢的字串有 24 位數，含連字號有 28 位數
     *
     * @param  boolean  $dash  是否輸出連字號
     * @return string
     */
    static public function Base62Guid($dash = false)
    {
        # 分隔符號，預設無（連字號 = false）
        $separator = $dash ? '-' : '';

        # 初始化 GUID
        $guid = self::Guid();

        # 依連字號將 GUID 各部份分成陣列
        $guidHex = explode('-', $guid);

        # 將 GUID 的 5 個部份分別先轉為 10 進制後，再轉為 62 進制，並分別補足成 6-3-3-3-9 結構
        foreach ($guidHex as $key => $idhex)
        {
            # GUID 的 5 個部份轉換成 62 進位制後，分別是 6、3、3、3、9 位數
            switch ($key)
            {
                case 0:
                    $pad = 6;
                    break;

                case 1:
                case 2:
                case 3:
                    $pad = 3;
                    break;

                case 4:
                    $pad = 9;
                    break;

                default:
                    break;
            }

            # 由 16 進制轉為 10 進制
            $guidDec[$key] = hexdec($idhex);

            # 由 10 進制轉為 62 進制
            $guidBase62[$key] = self::Base10To62($guidDec[$key]);

            # 轉換成 62 進制後，不足應有位數時，隨機在左邊（前面）補數字
            $len = strlen($guidBase62[$key]);
            $ret = '';
            if (strlen($len) < $pad)
            {
                for ($i = 0; $i < ($pad - $len); $i++)
                {
                    $ret .= self::Base62Dict[mt_rand(0, 61)];
                }
            }
            $guidBase62[$key] = $ret . $guidBase62[$key];
        }

        # 組合 62 進制 GUID 的 5 個部份成一整個字串，各部份可依連字號區隔
        $bguid = implode($separator, $guidBase62);

        # 返回 62 進制 GUID
        return $bguid;
    }

    /**
     * 將 16 進位的 TGUID 轉為 62 進位；轉換完畢的字串有 39 位數，含連字號有 45 位數
     *
     * @param  boolean  $dash  是否輸出連字號
     * @return string
     */
    static public function Base62Tguid($dash = false)
    {
        # 分隔符號，預設無（連字號 = false）
        $separator = $dash ? '-' : '';

        # 初始化 TGUID
        $tguid = self::Tguid16();

        # 依連字號將 TGUID 各部份分成陣列
        $tguidHex = explode('-', $tguid);

        # 將 TGUID 的 7 個部份均轉為 10 進制後，再轉為 62 進制，並分別補足成 10-5-6-3-3-3-9 結構
        foreach ($tguidHex as $key => $idhex)
        {
            # TGUID 的 7 個部份轉換成 62 進位制後，分別是 10、5、6、3、3、3、9 位數
            switch ($key)
            {
                case 0:
                    $pad = 10;
                    break;

                case 1:
                    $pad = 5;
                    break;

                case 2:
                    $pad = 6;
                    break;

                case 3:
                case 4:
                case 5:
                    $pad = 3;
                    break;

                case 6:
                    $pad = 9;
                    break;

                default:
                    break;
            }

            # 由 16 進制轉為 10 進制（第 2 部份 entropy 本來就是 10 進位，不轉）
            if ($key !== 1)
                $tguidDec[$key] = hexdec($idhex);
            else
                $tguidDec[$key] = $idhex;

            # 由 10 進制轉為 62 進制
            $tguidBase62[$key] = self::Base10To62($tguidDec[$key]);

            # 轉換成 62 進制後，不足應有位數時，第 1 部份（`uniqid()` 的時間）補 0，其餘部份隨機補數字
            $len = strlen($tguidBase62[$key]);
            $ret = '';
            if (strlen($len) < $pad)
            {
                for ($i = 0; $i < ($pad - $len); $i++)
                {
                    switch ($key)
                    {
                        case 0:
                            $ret .= '0';
                            break;

                        default:
                            $ret .= self::Base62Dict[mt_rand(0, 61)];
                            break;
                    }
                }
            }
            $tguidBase62[$key] = $ret . $tguidBase62[$key];
        }

        # 組合 62 進制 TGUID 的 7 個部份成一整個字串，各部份可依連字號區隔
        $bguid = implode($separator, $tguidBase62);

        # 返回 62 進制 TGUID
        return $bguid;
    }

    /**
     * 在 62 進位 TGUID 後面補上 3 位隨機數字，湊成 42 位；轉換完畢的字串有 42 位數，含連字號有 49 位數
     *
     * 生命、宇宙及萬事萬物的終極答案（Answer to the Ultimate Question of Life, The Universe, and Everything）！
     *
     * 原名 `Base62Tguid42` (`base62_tguid42`)
     *
     * @param  boolean  $dash  是否輸出連字號
     * @return string
     */
    static public function Tguid($dash = false)
    {
        # 分隔符號，預設無（連字號 = false）
        $separator = $dash ? '-' : '';

        # 有連字號時的總位數為 48（不含連接 TGUID 本體的最後一個連字號），沒有時為 42
        $digit = $dash ? 48 : 42;

        # 保險措施，避免 TGUID 居然超過 39 位數
        $bguid = self::Base62Tguid($dash);
        $len = strlen($bguid);

        # 在 TGUID 的最後面補足 62 進位數字
        $ret = '';
        for ($i = 0; $i < ($digit - $len); $i++)
        {
            $ret .= self::Base62Dict[mt_rand(0, 61)];
        }
        $bguid .= $separator . $ret;

        # 返回補到 42 位數的 TGUID
        return $bguid;
    }

    /**
     * 由 62 進位 TGUID 反推其時間；可檢測的最大時間為 3555-04-08 14:09:22.133048（zzzzzzzzzz）
     *
     * 原名 `base62_guid_to_time`
     *
     * @param  integer  $tguid  TGUID
     * @return string
     */
    static public function TguidToTime($tguid = 0)
    {
        # 擷取前 10 位數
        $num = substr($tguid, 0, 10);

        # 先轉為 10 進位，再轉回 16 進位
        $dec = self::Base62To10($num);
        $hex = dechex($dec);

        # 檢查有無溢位，用來決定以 16 進位值的第幾位作為秒級及微秒級時間戳的擷取分隔點
        # 62 進位的 5K1WLnfhB1 = 10 進位的 72,057,594,037,927,935 = 16 進位的 ff ffff ffff ffff（16^14 - 1）
        if ($dec > self::Base62To10('5K1WLnfhB1'))
            $sub = -5;
        else
            $sub = -6;

        # 擷取 16 進位的前 8 或 9 位，轉為 10 進位秒級以上時間戳，並轉回標準日期時間格式
        $timestampHex = substr($hex, 0, $sub);
        $timestampDec = hexdec($timestampHex);
        $date = date('Y-m-d H:i:s', $timestampDec);

        # 擷取 16 進位的後 5 或 6 位，轉為 10 進位微秒級時間戳（不準確）
        $microtimeHex = substr($hex, $sub);
        $microtimeDec = substr(str_pad(round(hexdec($microtimeHex), 6), 6, '0', STR_PAD_LEFT), 0, 6);

        # 返回標準日期時間格式 + 微秒
        return $date . '.' . $microtimeDec;
    }

    /**
     * 給定時間，轉成類似 62 進位 TGUID 的前 10 位數字
     *
     * 原名 `time_to_base62_guid`
     *
     * @param  string  $time  時間字串
     * @return string
     */
    static public function TimeToBase62Guid($time = '')
    {
        # 時間為預設值（空字串）時，指定 $time 為 ISO 格式帶微秒
        if ($time == '')
        {
            $time = date('Y-m-d H:i:s.u');
        }

        # 去除輸入時間中的引號
        $time = str_replace('"', '', $time);
        $time = str_replace("'", '', $time);

        # 輸入的時間符合 ISO 格式但未帶微秒時，自動補上
        if (preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $time))
        {
            $time .= '.000000';
        }
        else
        {
            # 輸入時間不符合 ISO 格式也不包含微秒時，返回 null
            if (!preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\.\d{1,6}$/', $time))
            {
                return null;
            }
        }

        # 分解時間字串為秒以上部分及微秒部分
        $date = explode('.', $time)[0];
        $microtime = explode('.', $time)[1];

        # 秒以上時間字串轉為 16 進位時間戳
        $timestampDec = strtotime($date);
        $timestampHex = dechex($timestampDec);

        # 微秒字串向右補 0 至 6 位數後轉 16 進位，再向左補 0 至 6 位數
        $microtimeDec = str_pad($microtime, 6, '0', STR_PAD_RIGHT);
        $microtimeHex = str_pad(dechex($microtimeDec), 6, '0', STR_PAD_LEFT);

        # 組合 16 進位的時間字串
        $prototHex = $timestampHex . $microtimeHex;

        # 將 16 進位時間字串轉為 62 進位
        $base62 = gmp_strval(gmp_init($prototHex, 16), 62);

        # 在 62 進位時間字串的左方補 0 至 10 位數
        $base62 = str_pad($base62, 10, '0', STR_PAD_LEFT);

        return $base62;
    }

    /**
     * 返回 UTF-8 編碼、Unicode 及反斜線不轉義的 JSON 資料
     *
     * @param  array|object  $data  待轉為 JSON 的資料
     * @return string
     */
    static public function JsonUnescaped($data)
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    /**
     * 返回 UTF-8 編碼、Unicode 及反斜線不轉義且格式化的 JSON 資料
     *
     * @param  array|object  $data  待轉為 JSON 的資料
     * @return string
     */
    static public function JsonPrettyPrinted($data)
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    /**
     * 將 JSON 字串中的「"{}"」兩側的雙引號去除，使成為標準的 JSON 空物件
     *
     * @param  string  $json  JSON 字串
     * @return string
     */
    static public function JsonEmptyObject($json = '"{}"')
    {
        return preg_replace('/\"\{\}\"/', '{}', $json);
    }

    /**
     * 返回僅有 title 的空頁面 HTML 碼
     *
     * @param  string  $title  頁面標題
     * @return string
     */
    static public function TitleOnlyPage($title)
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

    /**
     * 在指定的資源路徑後加上指定長度的隨機 Base62 字串
     *
     * @param  string   $path    資源路徑
     * @param  integer  $length  Base62 字串長度
     * @return string
     */
    static public function AssetCachebuster($path, $length = 0)
    {
        # 指定的路徑未以斜線開頭時，自動加入斜線，確保資源由網站根目錄開始定位
        if (!preg_match('/^\//', $path))
        {
            $path = '/' . $path;
        }

        if ($length > 0)
        {
            return $path . '?' . self::StrBase62($length);
        }
        else
        {
            return $path;
        }
    }

    /**
     * 配合 `AssetCachebuster` 方法所使用的隨機 Base62 字串長度
     *
     * @var integer
     */
    const CachebusterLength = 22;
}
