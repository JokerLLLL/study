<?php

var_dump(strpos('aaa', 'aaaxxaaxx')); // 没有返回false 有返回 位置 可能返回0
var_dump(preg_match('/aaa/', 'aaxaxxaaxacvvaaxa')); // 返回匹配到的个数 0 或 1
$email = "/^[A-z]@[]\.[A-z]$/";


//preg_match();
//preg_match_all();
//preg_replace()
//preg_replace_callback() 返回值是callback 的发返回指
//preg_filter()  // 针对 array的匹配项目，replace目标，没有的过滤。 字符串返回空 数据舍弃数据。
//preg_grep() // 筛选
//preg_split() //正则分割
//preg_quote() // 转移成正则表达式