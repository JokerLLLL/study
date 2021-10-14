<?php


$a["zw"] = "中国";
$a["fxg"] = "aaa\\n\\\k/// ";
$a["jt"] = "<span></span>####aaa\\n\\\k ";

var_dump(json_encode($a));
var_dump(json_encode($a, JSON_UNESCAPED_SLASHES));

var_dump(json_encode($a, JSON_HEX_AMP | JSON_HEX_TAG));