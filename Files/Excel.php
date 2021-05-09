<?php

if (!function_exists('ExcelColumnToNumber'))
{
    /**
     * 將 Excel A1 參照樣式中的欄位序號轉為數字（Office 2019 的最大值為 XFD = 16384）
     *
     * @param  string  $Column  欄位序號
     * @return integer|boolean
     */
    function ExcelColumnToNumber($Column)
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
}

if (!function_exists('NumberToExcelColumn'))
{
    /**
     * 將數字轉為 Excel A1 參照樣式中的欄位序號（Office 2019 的最大值為 XFD = 16384）
     *
     * @param  integer  $Number  欄位序數
     * @return string
     */
    function NumberToExcelColumn($Number)
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
}
