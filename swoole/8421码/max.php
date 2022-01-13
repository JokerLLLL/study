<?php

var_dump(PHP_INT_MAX);

var_dump(PHP_INT_MIN);

var_dump(PHP_FLOAT_MAX);
var_dump(PHP_FLOAT_MIN);

$xx = INF;
$a = PHP_FLOAT_MAX * PHP_FLOAT_MIN;
//$b = PHP_INT_MAX * 1.01;
$c = PHP_FLOAT_MIN / PHP_FLOAT_MAX;

var_dump(PHP_INT_MIN * PHP_INT_MAX);
var_dump($xx,$a,$c);
var_dump(is_float($xx));
var_dump($xx === $a);

var_dump(1.7976931348623e+308 + 1e+294);

var_dump(1e1);
var_dump(exp(1));

var_dump(PHP_INT_MAX, pow(2,64));


