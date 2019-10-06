<?php

header('content-type: text/plain');

require_once('str_base62.php');
require_once('guid.php');
require_once('tguid.php');

echo str_base62(5);

echo PHP_EOL;

echo guid();

echo PHP_EOL;

echo base62_tguid42(true);