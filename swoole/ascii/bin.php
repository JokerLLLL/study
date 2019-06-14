<?php

// 位运算 的 减去
var_dump(15 &~ 10); // 12
//等同：
decbin(bindec('01111') &~ bindec('011')); // string(4) "1100"

//位的 append 操作
bindec('0101') | bindec('01'); // bindec('0101')
bindec('0101') | bindec('011'); // bindec('0111')
bindec('0101') | bindec('010'); // bindec('0111')



function testBite(int $value) {
    $count = strlen(decbin($value));
    $bite = 1;
    for($i = 1; $i <= $count ;$i ++) {
        if($value & $bite) {
            echo 'bite:'.$i.' is 1'.PHP_EOL;
        }else{
            echo 'bite:'.$i.' is 0'.PHP_EOL;
        }
        $bite *= 2;
    }
}

testBite(bindec('10010101000'));

