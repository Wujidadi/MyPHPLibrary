<?php

if (!function_exists('IsSafe'))
{
    /**
     * 檢查輸入值是否存在、不為 null、false 或空字串，返回 true 或 false
     * 
     * 0、字元 0（'0'）及空陣列或空物件視為 true
     *
     * @param integer|string|array|object $value
     * @return boolean
     */
    function IsSafe($value = null)
    {
        switch (true)
        {
            case (isset($value) && !is_null($value) && !empty($value)):
            case (isset($value) && !is_null($value) && empty($value) && $value === 0):
            case (isset($value) && !is_null($value) && empty($value) && $value === '0'):
            case (isset($value) && !is_null($value) && empty($value) && is_array($value)):
                return true;

            default:
                return false;
        }
    }
}
