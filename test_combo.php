<?php

/* 引入各個分開的檔案 */
require_once('Files/Type.php');
require_once('Files/MsTime.php');
require_once('Files/Json.php');
require_once('Files/Format.php');
require_once('Files/String.php');
require_once('Files/Variable.php');
require_once('Files/Regex.php');
require_once('Files/Excel.php');
require_once('Files/Base62.php');
require_once('Files/Guid.php');
require_once('Files/Tguid.php');
require_once('Files/Cachebuster.php');

/*
 *=============================
 * 引入各分檔的測試
 *=============================
 */

echo IsSafe(null) ? 'True' : 'False';
echo PHP_EOL;

echo MsTime();
echo PHP_EOL;

echo MsTimestamp();
echo PHP_EOL;

echo VarExportFormat([
    'name' => 'Taras',
    'status' => [
        'live' => true,
        'disability' => false
    ],
    'info' => (object) [
        'age' => 34,
        'location' => 'Taiwan',
        'power' => 777,
        'mechanism' => (object) [
            'type' => 'SE',
            'seniority' => 3
        ]
    ]
]);
echo PHP_EOL;

echo JsonUnescaped([ 'Chinese' => 'Chang Cheng-kang', 'Quenya' => 'Taras Alatmiuë' ]);
echo PHP_EOL;

echo EmailFormat;
echo PHP_EOL;

echo 'A' . Blank(8) . 'B';
echo PHP_EOL;

echo RemoveTrailingZeros('59.666900');
echo PHP_EOL;

echo CombineRegex($regSeg);
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
