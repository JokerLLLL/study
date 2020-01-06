<?php
/**
 * Created by PhpStorm.
 * User: jokerl
 * Date: 2018/11/30
 * Time: 13:58
 */
// 加
echo bcadd(1,2.888,3).PHP_EOL;

// 减
echo bcsub(99,10000,4).PHP_EOL;

// 乘
echo bcmul(3,33.3,3).PHP_EOL;

// 除
echo bcdiv(33,7,5).PHP_EOL;

//取模
echo bcmod(18,7).PHP_EOL;

//指数
echo bcpow(3.3,2,2).PHP_EOL;

//精度比较
echo bccomp(1.0003,1,6).PHP_EOL;


//判断正整数

### 正整数判断
$day = '111';

if(preg_match("/^[1-9][0-9]*$/", $day)) { /// 排除了 0111
   echo '正整数';
}

if(is_numeric($day) && floor(abs($day)) == $day) { // 全部；
    echo '正整数';
}



