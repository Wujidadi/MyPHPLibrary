<?php

/* 指定命名空間並引入 Helpers class */
namespace App; require_once('Classes/Helpers.php');
use App\Classes\Helpers as Helpers;

/* 引入各個分開的檔案 */
// require_once('Files/MsTime.php');
// require_once('Files/Json.php');
// require_once('Files/Format.php');
// require_once('Files/Excel.php');
// require_once('Files/Base62.php');
// require_once('Files/Guid.php');
// require_once('Files/Tguid.php');

header('content-type: text/plain');


/*
 *=============================
 * 引入各分檔的測試
 *=============================
 */

// echo MsTimestamp();
// echo PHP_EOL;

// echo JsonUnscaped([ 'Chinese' => 'Chang Cheng-kang', 'Quenya' => 'Taras Alatmiuë' ]);
// echo PHP_EOL;

// echo EmailFormat;
// echo PHP_EOL;

// echo ExcelColumnToNumber('xfd');
// echo PHP_EOL;

// echo NumberToExcelColumn(702);
// echo PHP_EOL;

// echo StrBase62(5);
// echo PHP_EOL;

// echo Guid();
// echo PHP_EOL;

// echo Base62To10(18);
// echo PHP_EOL;

// echo Base62Tguid(true);
// echo PHP_EOL;

// echo Tguid(true);
// echo PHP_EOL;

// echo TguidToTime('1xiDqwk9pJ');
// echo PHP_EOL;

// echo TimeToBase62Guid('2020-03-12 12:26:20.113359');
// echo PHP_EOL;


/*
 *=============================
 * 引入 Helpers class 的測試
 *=============================
 */

echo Helpers::Time();
echo PHP_EOL;

echo Helpers::Timestamp();
echo PHP_EOL;

echo Helpers::JsonUnscaped(['Chinese' => 'Chang Cheng-kang', 'Quenya' => 'Taras Alatmiuë']);
echo PHP_EOL;

echo Helpers::EmailFormat;
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
