<?php

/**
 * 示例函数
 */
function add( $a, $b )
{
    return $a + $b;
}

/**
 * 创建柯里化的函数
 */
function curry( $fn )
{
    // 把第2个及以后的参数截出来
    $args = func_get_args();
    $outerArgs = array_slice( $args, 1 );

    // 匿名函数
    $retFn = function () use ( $fn, $outerArgs )
    {
        // 把上面截出来的函数和本次匿名函数传进来的合并
        $args = array_merge( $outerArgs, func_get_args());
        // 调用
        return call_user_func_array( $fn, $args );
    };

    return $retFn;
}

$fn = curry( 'add', 5 );  //fn = function(){ call_func('add',[5] + func_get_args()}  + 3

var_dump( $fn( 3 )); // = 8

$fn2 = curry( 'add', 10 );
