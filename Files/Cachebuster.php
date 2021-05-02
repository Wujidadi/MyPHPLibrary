<?php

if (function_exists('StrBase62'))
{
    if (!function_exists('AssetCachebuster'))
    {
        /**
         * 在指定的資源路徑後加上指定長度的隨機 Base62 字串
         *
         * @param  string  $path   資源路徑
         * @param  integer $length Base62 字串長度
         * @return string
         */
        function AssetCachebuster($path, $length = 0)
        {
            // 指定的路徑未以斜線開頭時，自動加入斜線，確保資源由網站根目錄開始定位
            if (!preg_match('/^\//', $path))
            {
                $path = '/' . $path;
            }

            if ($length > 0)
            {
                return $path . '?' . StrBase62($length);
            }
            else
            {
                return $path;
            }
        }
    }
}

if (!defined('CachebusterLength'))
{
    /**
     * 配合 `AssetCachebuster` 方法所使用的隨機 Base62 字串長度
     *
     * @var integer
     */
    define('CachebusterLength', 24);
}
