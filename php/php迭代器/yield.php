<?php
//来源 https://www.cnblogs.com/lynxcat/p/7954456.html

function gen($a){
    while($a) {
        yield "gen\n";
    }
}

$gen = gen(true);

var_dump($gen instanceof Iterator); //true

$i = 0;
foreach ($gen as $key => $value) {
    echo "{$key} - {$value}";
    if(++$i >= 10){
        break;
    }
}
//上面代码等同于

$gen = gen(true);
var_dump($gen->valid());
echo $gen->key().' - '.$gen->current()."\n";
$gen->next();
var_dump($gen->valid());
echo $gen->key().' - '.$gen->current()."\n";
$gen->next();
var_dump($gen->valid());
echo $gen->key().' - '.$gen->current()."\n";
$gen->next();
var_dump($gen->valid());
//.....


/**
 说明 yield 实现 Iterator的 迭代器         =》返回的是 final class Generator implements Iterator{}
*/


/**
1.yield只能用于函数内部，在非函数内部运用会抛出错误。
2.如果函数包含了yield关键字的，那么函数执行后的返回值永远都是一个Generator对象。
3.如果函数内部同事包含yield和return 该函数的返回值依然是Generator对象，但是在生成Generator对象时，return语句后的代码被忽略。
4.Generator类实现了Iterator接口。
5.可以通过返回的Generator对象内部的方法，获取到函数内部yield后面表达式的值。
 *
6.可以通过Generator的send方法给yield 关键字赋一个值。                 //实现swoole协成的关键
7.一旦返回的Generator对象被遍历完成，便不能调用他的rewind方法来重置
8.Generato
*/


echo $gen->send("send value - ");
//代替 yeild 关键字处的值 返回值是 next() current()的值 //说明迭代了一次

//e.g
function gen4(){
    $id = 2;
    $id = yield $id;
    echo $id;
}

$gen = gen4();
$gen->send($gen->current() + 3);
