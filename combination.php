<?php

/* 引入統合的 Helpers 檔案 */
require_once('Combination/Helpers.php');

header('content-type: text/plain');

echo IsSafe(null) ? 'True' : 'False';
echo PHP_EOL;

echo MsTime();
echo PHP_EOL;

echo MsTimestamp();
echo PHP_EOL;

echo JsonUnescaped([ 'Chinese' => 'Chang Cheng-kang', 'Quenya' => 'Taras Alatmiuë' ]);
echo PHP_EOL;

echo EmailFormat;
echo PHP_EOL;

echo RemoveTrailingZeros('59.666900');
echo PHP_EOL;

echo ExcelColumnToNumber('xfd');
echo PHP_EOL;

echo NumberToExcelColumn(702);
echo PHP_EOL;

echo StrBase62(5);
echo PHP_EOL;

echo Guid();
echo PHP_EOL;

echo Base62To10(18);
echo PHP_EOL;

echo Base62Tguid(true);
echo PHP_EOL;

echo Tguid(true);
echo PHP_EOL;

echo TguidToTime('1xiDqwk9pJ');
echo PHP_EOL;

echo TimeToBase62Guid('2020-03-12 12:26:20.113359');
echo PHP_EOL;

echo AssetCachebuster('css/style.css', CachebusterLength);
echo PHP_EOL;