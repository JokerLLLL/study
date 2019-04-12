<?php


function a($a,$b,$c,$d=null,$f=[])
{

}


function b($a,$b,$c,$d=null,$f=[]) {
    $array = [1,3,'cava','66666'];
    var_dump(...$array);
    var_dump(func_get_arg(2));
}

b('aaa','bbb','ccc');


