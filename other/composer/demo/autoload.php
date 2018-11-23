<?php
/**
 * Created by PhpStorm.
 * User: jokerl
 * Date: 2018/11/23
 * Time: 16:04
 */

//function __autoload($class)
//{
//    require $class.'.php';
//}


spl_autoload_register('auto');
spl_autoload_register('auto2');
function auto($class){
    echo 'start auto'.PHP_EOL;
    require 'a.php';
    require $class.'.php';
}

new Test();