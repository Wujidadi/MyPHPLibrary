<?php

if (!function_exists('IsSafe'))
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
    function IsSafe($value = null)
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
}
