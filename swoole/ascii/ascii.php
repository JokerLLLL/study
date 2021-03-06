<?php
/**
 * php 的进制表示
 * 在echo输出的时候,不管是什么类型的整数,最后输出的都是十进制
 */

$n = 0b10000 ;   //二进制
$n = 16;         //十进制
$n = 0x10;       //十六进制
$n = 020;        //八进制
echo 0x41;  //65

/**
 * echo输出的时候,会输出字符DLE
 *
 */
//\[0-7]{1,3}           #八进制表达方式
//\x[0-9A-Fa-f]{1,2}    #十六进制表达方式
echo "\x7E";  //十六进制字符串  ~
echo "\176";  //八进制字符串    ~

/**
 * 以下都成立
 */
if (0x41 === 65) {
    echo 'true'; //成立
}

if ("\x7E" === "~") {
    echo 'true'; //成立
}

if(chr(0x7e) === "~") {
    echo 'true';  //成立
}


/**
 * 进制转换
 */

$n = 16;
echo $n.'-'.dechex($n) . "-" . decbin($n).PHP_EOL;
$n = base_convert('10',16,10 ); //'10'本身的进制由第二个参数决定 得到的是字符串
$nn = base_convert($n, 10,2 );
echo $n . "-" . $nn .PHP_EOL;


//ASCII 转可见字符串
echo chr(65);                 //十进制，由于都输数，所以没必要加双引号了
echo chr(0x41);               //十六进制
echo chr(0101);               //八进制，三位，最高位补零
echo chr('01000001');         //二进制，注意，这里的二进制一定要看做字符串，加引号！上面三个都不用加

//可见字符串 转ASCII 10进制
echo ord("\x7e");   //126

var_dump(bindec('1100')); //二进制转  10进制
var_dump(hexdec('FF'));     //16进制转  10进制

var_dump(0x80);
var_dump(hexdec('ff'));


