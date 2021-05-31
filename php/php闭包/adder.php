<?php

// https://www.cnblogs.com/JosephLiu/archive/2011/11/08/2241810.html
// &a++ 改 ++$a

/**
 * 示例函数
 */
function add($a)
{
    return ++$a;
}

/**
 * 创建柯里化的函数
 */
function curry($fn)
{
    $num = 0;
    // 匿名函数
    $retFn = function () use ($fn, &$num) {
        // 调用
        $num = call_user_func($fn, $num);
        return $num;
    };

    return $retFn;
}

$fn = curry('add');

var_dump($fn()); // 1
var_dump($fn()); // 1
var_dump($fn()); // 1


