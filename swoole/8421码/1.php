<?php
/**
 * Created by PhpStorm.
 * User: jokerl
 * Date: 2018/11/2
 * Time: 11:04
 */


$byte = 'ca';
$arr = array(0x80,0x40,0x20,0x10,0x08,0x04,0x02,0x01);

foreach ($arr as $a){
    $data[] = hexdec($byte) & $a ? 1 : 0;
}

var_dump($data);

var_dump(base_convert($byte,16,2));