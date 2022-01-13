<?php

$xString = "\xE4\xB8\x89 \xE7\xBA\xA7 \xE8\x8A\x82 \xE7\x82\xB9";

echo $xString;
echo ToUnicode($xString);
echo UnicodeEncode($xString);

$uString = "\u4f60\u597d";


function UnicodeEncode($str){
    //split word
    preg_match_all('/./u',$str,$matches);
    $unicodeStr = "";
    foreach($matches[0] as $m){
        //拼接
        $unicodeStr .= "\\u".base_convert(bin2hex(iconv('UTF-8',"UCS-4",$m)),16,10);
    }
    return $unicodeStr;
}

function ToUnicode($s)
{
    return substr(json_encode($s), 1, -1);
}

$str = "新浪微博";
$u = UnicodeEncode($str);
echo $u;


$s = "新浪微博";
$unicodeS = ToUnicode($s);
echo $unicodeS;
echo unicodeDecode($unicodeS);
echo decodeUnicode($unicodeS);

function unicodeDecode($unicode_str){
    $json = '{"str":"'.$unicode_str.'"}';
    $arr = json_decode($json,true);
    if(empty($arr)) return '';
    return $arr['str'];
}

//把unicode转化成中文
function decodeUnicode($str) {
    return preg_replace_callback('/\\\\u([0-9a-f]{4})/i',
        function ($matches) {
            var_dump($matches);
            return mb_convert_encoding(pack("H*", $matches[1]), "UTF-8", "UCS-2BE");
        },
        $str);
}


$unicode_str = "\u65b0\u6d6a\u5fae\u535a";
echo unicodeDecode($unicode_str);

$x = "\xE4\xB8\x89"; // utf8
$u = "\u{4e09}";    // unicode
$c = "三"; // 字符
var_dump($x === $u, $u === $c);

echo PHP_EOL."小仙女试验：" .PHP_EOL;


$xxn = " ??小�仙女🧚 ";
echo "\u{FFFD}";

echo $xxn;
//$text = preg_replace('/[\x{10000}-\x{10FFFF}]/u', "\u{FFFD}", $text);





