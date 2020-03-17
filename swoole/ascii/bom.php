<?php

require_once "hex.php";

$s = file_get_contents('./test.txt'); //utf-16le

if($s === "\xFF\xFE")
    echo true;

var_dump($handle->SetToHexString($s)); // fffe 头

$s = iconv('UCS-2LE', 'UTF-8', $s);

var_dump($handle->SetToHexString($s));  // efbbbf  (说明  bom头是 \xEF\xBB\xBF)





