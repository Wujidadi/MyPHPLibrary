<?php

/* 指定命名空間並引入 Helpers class */
require_once 'Classes/Helpers.php';
use App\Classes\Helpers as Helpers;

/*
 *=============================
 * 引入 Helpers class 的測試
 *=============================
 */

echo Helpers::IsSafe((object)[]) ? 'True' : 'False';
echo PHP_EOL;

echo Helpers::Time();
echo PHP_EOL;

echo Helpers::Timestamp();
echo PHP_EOL;

echo Helpers::VarExportFormat([
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

echo Helpers::JsonUnescaped(['Chinese' => 'Chang Cheng-kang', 'Quenya' => 'Taras Alatmiuë']);
echo PHP_EOL;

echo Helpers::EmailFormat;
echo PHP_EOL;

echo 'A' . Helpers::Blank(13) . 'B';
echo PHP_EOL;

echo Helpers::RemoveTrailingZeros('59.666900');
echo PHP_EOL;

echo Helpers::CombineRegex($regSeg);
echo PHP_EOL;

echo Helpers::ExcelColumnToNumber('xfd');
echo PHP_EOL;

echo Helpers::NumberToExcelColumn(702);
echo PHP_EOL;

echo Helpers::StrBase62(5);
echo PHP_EOL;

echo Helpers::Guid();
echo PHP_EOL;

echo Helpers::Base62To10(18);
echo PHP_EOL;

echo Helpers::Base62Tguid(true);
echo PHP_EOL;

echo Helpers::Tguid(true);
echo PHP_EOL;

echo Helpers::TguidToTime('1xiDqwk9pJ');
echo PHP_EOL;

echo Helpers::TimeToBase62Guid('2020-03-12 12:26:20.113359');
echo PHP_EOL;

echo Helpers::AssetCachebuster('css/style.css', Helpers::CachebusterLength);
echo PHP_EOL;
