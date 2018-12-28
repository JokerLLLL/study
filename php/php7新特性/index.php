<?php
/**
 * Created by PhpStorm.
 * User: JokerL
 * Date: 2018/12/23
 * Time: 14:08
 */

require_once 'Test.php';

 var_dump(Test::PHP7_ARRAY_CONST);

 const A = [1];

 define('B',[222]);

 var_dump(A,B);

 class B{
     function __construct(float $a)
     {
     }
     function say()
     {

     }
 }


$r = (new Test())->get(__DIR__.'/test');

 var_dump($r);


(new class extends B{})->say();