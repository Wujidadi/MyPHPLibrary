<?php

if (defined('Base62Dict') && function_exists('Guid'))
{
    if (!function_exists('Uuid'))
    {
        /**
         * 將 PHP 內建函數 `uniqid()` 產生的 ID（不含熵）直接插入到 GUID 前面，並把被擠出去的原 GUID 字元刪除，維持 32 位數，並保留連字號
         *
         * @return string
         */
        function Uuid()
        {
            $unid = uniqid() . str_replace('-', '', guid());
            $uuid = substr($unid, 0, 8) . '-' . substr($unid, 8, 4) . '-' . substr($unid, 12, 4) . '-' . substr($unid, 16, 4) . '-' . substr($unid, 20, 12);
            return $uuid;
        }
    }

    if (!function_exists('Tguid16'))
    {
        /**
         * 產生 16 進位 GUID，再將 `uniqid()` 產生的 ID（含熵）插入 GUID 前面，並以連字號相連；整個字串長達 14 + 8 + 32 = 54 位數，含連字號為 60 位數
         *
         * @return string
         */
        function Tguid16()
        {
            $tguid = str_replace('.', '-', uniqid('', true)) . '-' . guid();
            return $tguid;
        }
    }

    if (!function_exists('Base62Guid'))
    {
        if (function_exists('Base10To62'))
        {
            /**
             * 將 16 進位的 GUID 轉為 62 進位；轉換完畢的字串有 24 位數，含連字號有 28 位數
             *
             * @param  boolean $dash 是否輸出連字號
             * @return string
             */
            function Base62Guid($dash = false)
            {
                // 分隔符號，預設無（連字號 = false）
                $separator = $dash ? '-' : '';

                // 初始化 GUID
                $guid = Guid();

                // 依連字號將 GUID 各部份分成陣列
                $guidHex = explode('-', $guid);

                // 將 GUID 的 5 個部份分別先轉為 10 進制後，再轉為 62 進制，並分別補足成 6-3-3-3-9 結構
                foreach ($guidHex as $key => $idhex)
                {
                    // GUID 的 5 個部份轉換成 62 進位制後，分別是 6、3、3、3、9 位數
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

                    // 由 16 進制轉為 10 進制
                    $guidDec[$key] = hexdec($idhex);

                    // 由 10 進制轉為 62 進制
                    $guidBase62[$key] = Base10To62($guidDec[$key]);

                    // 轉換成 62 進制後，不足應有位數時，隨機在左邊（前面）補數字
                    $len = strlen($guidBase62[$key]);
                    $ret = '';
                    if (strlen($len) < $pad)
                    {
                        for ($i = 0; $i < ($pad - $len); $i++)
                        {
                            $ret .= Base62Dict[mt_rand(0, 61)];
                        }
                    }
                    $guidBase62[$key] = $ret . $guidBase62[$key];
                }

                // 組合 62 進制 GUID 的 5 個部份成一整個字串，各部份可依連字號區隔
                $bguid = implode($separator, $guidBase62);

                // 返回 62 進制 GUID
                return $bguid;
            }
        }
    }

    if (!function_exists('Base62Tguid'))
    {
        if (function_exists('Tguid16') && function_exists('Base10To62'))
        {
            /**
             * 將 16 進位的 TGUID 轉為 62 進位；轉換完畢的字串有 39 位數，含連字號有 45 位數
             *
             * @param  boolean $dash 是否輸出連字號
             * @return string
             */
            function Base62Tguid($dash = false)
            {
                // 分隔符號，預設無（連字號 = false）
                $separator = $dash ? '-' : '';

                // 初始化 TGUID
                $tguid = Tguid16();

                // 依連字號將 TGUID 各部份分成陣列
                $tguidHex = explode('-', $tguid);

                // 將 TGUID 的 7 個部份均轉為 10 進制後，再轉為 62 進制，並分別補足成 10-5-6-3-3-3-9 結構
                foreach ($tguidHex as $key => $idhex)
                {
                    // TGUID 的 7 個部份轉換成 62 進位制後，分別是 10、5、6、3、3、3、9 位數
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

                    // 由 16 進制轉為 10 進制（第 2 部份 entropy 本來就是 10 進位，不轉）
                    if ($key !== 1)
                        $tguidDec[$key] = hexdec($idhex);
                    else
                        $tguidDec[$key] = $idhex;

                    // 由 10 進制轉為 62 進制
                    $tguidBase62[$key] = Base10To62($tguidDec[$key]);

                    // 轉換成 62 進制後，不足應有位數時，第 1 部份（uniqid() 的時間）補 0，其餘部份隨機補數字
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
                                    $ret .= Base62Dict[mt_rand(0, 61)];
                                    break;
                            }
                        }
                    }
                    $tguidBase62[$key] = $ret . $tguidBase62[$key];
                }

                // 組合 62 進制 TGUID 的 7 個部份成一整個字串，各部份可依連字號區隔
                $bguid = implode($separator, $tguidBase62);

                // 返回 62 進制 TGUID
                return $bguid;
            }
        }
    }

    if (!function_exists('Tguid'))
    {
        if (function_exists('Base62Tguid'))
        {
            /**
             * 在 62 進位 TGUID 後面補上 3 位隨機數字，湊成 42 位；轉換完畢的字串有 42 位數，含連字號有 49 位數
             *
             * 生命、宇宙及萬事萬物的終極答案（Answer to the Ultimate Question of Life, The Universe, and Everything）！
             *
             * 原名 `Base62Tguid42` (`base62_tguid42`)
             *
             * @param  boolean $dash 是否輸出連字號
             * @return string
             */
            function Tguid($dash = false)
            {
                // 分隔符號，預設無（連字號 = false）
                $separator = $dash ? '-' : '';

                // 有連字號時的總位數為 48（不含連接 TGUID 本體的最後一個連字號），沒有時為 42
                $digit = $dash ? 48 : 42;

                // 保險措施，避免 TGUID 居然超過 39 位數
                $bguid = Base62Tguid($dash);
                $len = strlen($bguid);

                // 在 TGUID 的最後面補足 62 進位數字
                $ret = '';
                for ($i = 0; $i < ($digit - $len); $i++)
                {
                    $ret .= Base62Dict[mt_rand(0, 61)];
                }
                $bguid .= $separator . $ret;

                // 返回補到 42 位數的 TGUID
                return $bguid;
            }
        }
    }

    if (!function_exists('TguidToTime'))
    {
        /**
         * 由 62 進位 TGUID 反推其時間；可檢測的最大時間為 3555-04-08 14:09:22.133048（zzzzzzzzzz）
         *
         * 原名 `base62_guid_to_time`
         *
         * @param  integer $tguid TGUID
         * @return string
         */
        function TguidToTime($tguid = 0)
        {
            // 擷取前 10 位數
            $num = substr($tguid, 0, 10);

            // 先轉為 10 進位，再轉回 16 進位
            $dec = Base62To10($num);
            $hex = dechex($dec);

            /**
             * 檢查有無溢位，用來決定以 16 進位值的第幾位作為秒級及微秒級時間戳的擷取分隔點
             * 62 進位的 5K1WLnfhB1 = 10 進位的 72,057,594,037,927,935 = 16 進位的 ff ffff ffff ffff（16^14 - 1）
             */
            if ($dec > Base62To10('5K1WLnfhB1'))
                $sub = -5;
            else
                $sub = -6;

            // 擷取 16 進位的前 8 或 9 位，轉為 10 進位秒級以上時間戳，並轉回標準日期時間格式
            $timestampHex = substr($hex, 0, $sub);
            $timestampDec = hexdec($timestampHex);
            $date = date('Y-m-d H:i:s', $timestampDec);

            // 擷取 16 進位的後 5 或 6 位，轉為 10 進位微秒級時間戳（不準確）
            $microtimeHex = substr($hex, $sub);
            $microtimeDec = substr(str_pad(round(hexdec($microtimeHex), 6), 6, '0', STR_PAD_LEFT), 0, 6);

            // 返回標準日期時間格式 + 微秒
            return $date . '.' . $microtimeDec;
        }
    }

    if (!function_exists('TimeToBase62Guid'))
    {
        /**
         * 給定時間，轉成類似 62 進位 TGUID 的前 10 位數字
         *
         * 原名 `time_to_base62_guid`
         *
         * @param  string $time 時間字串
         * @return string
         */
        function TimeToBase62Guid($time = '')
        {
            // 時間為預設值（空字串）時，指定 $time 為 ISO 格式帶微秒
            if ($time == '')
            {
                $time = date('Y-m-d H:i:s.u');
            }

            // 去除輸入時間中的引號
            $time = str_replace('"', '', $time);
            $time = str_replace("'", '', $time);

            // 輸入的時間符合 ISO 格式但未帶微秒時，自動補上
            if (preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/', $time))
            {
                $time .= '.000000';
            }
            else
            {
                // 輸入時間不符合 ISO 格式也不包含微秒時，返回 null
                if (!preg_match('/^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\.\d{1,6}$/', $time))
                {
                    return null;
                }
            }

            // 分解時間字串為秒以上部分及微秒部分
            $date = explode('.', $time)[0];
            $microtime = explode('.', $time)[1];

            // 秒以上時間字串轉為 16 進位時間戳
            $timestampDec = strtotime($date);
            $timestampHex = dechex($timestampDec);

            // 微秒字串向右補 0 至 6 位數後轉 16 進位，再向左補 0 至 6 位數
            $microtimeDec = str_pad($microtime, 6, '0', STR_PAD_RIGHT);
            $microtimeHex = str_pad(dechex($microtimeDec), 6, '0', STR_PAD_LEFT);

            // 組合 16 進位的時間字串
            $prototHex = $timestampHex . $microtimeHex;

            // 將 16 進位時間字串轉為 62 進位
            $base62 = gmp_strval(gmp_init($prototHex, 16), 62);

            // 在 62 進位時間字串的左方補 0 至 10 位數
            $base62 = str_pad($base62, 10, '0', STR_PAD_LEFT);

            return $base62;
        }
    }
}
