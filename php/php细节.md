
#array_merger 和 + 的区别 
1. 当下标为数值时，array_merge()不会覆盖掉原来的值，但array＋array合并数组则会把最先出现的值作为最终结果返回，而把后面的数组拥有相同键名的那些值“抛弃”掉（不是覆盖）. 
2. 当下标为字符时，array＋array仍然把最先出现的值作为最终结果返回，而把后面的数组拥有相同键名的那些值“抛弃”掉，但array_merge()此时会覆盖掉前面相同键名的值. 

+ 前面的不动，后来者往里加。 merger 后来者居上，数字下标重写


#php强制类型转换

if('aa' == 0) {
  echo '在php中非数字字符，和数字比较都是intval()处理 再进行比较；包括在switch中；
}


# php时间函数修正

var_dump(date("Y-m-d", strtotime("-1 month", strtotime("2017-03-31"))));
//输出2017-03-03
var_dump(date("Y-m-d", strtotime("+1 month", strtotime("2017-08-31"))));
//输出2017-10-01

//修正函数
var_dump(date("Y-m-d", strtotime("last day of -1 month", strtotime("2017-03-31"))));
//输出2017-02-28
var_dump(date("Y-m-d", strtotime("first day of +1 month", strtotime("2017-08-31"))));
////输出2017-09-01
var_dump(date("Y-m-d", strtotime("first day of next month", strtotime("2017-01-31"))));
////输出2017-02-01
var_dump(date("Y-m-d", strtotime("last day of last month", strtotime("2017-03-31"))));


# mb_substr('函数',1,1,'utf-8');

linux环境下要传入utf-8 才行


# 运算符先后

// 得到的 $var 是比较的boolean值
if($var = $a === $b) {
  return $var;
}

// 得到的 $var 是$a 的赋值
if(($var = $a) === $b) {
    return $var;
}

# 无限极参数

php 7 的特性

funciton(...$params){
    var_dump($params);
}

var_dump(...['a','b','c']);

/* @var $example boolean or 'test''*/
$example = empty($a) ??'test';

## php引用的坑
http://php.net/manual/en/function.unset.php
https://blog.csdn.net/tingliting/article/details/49615135

引用传值 unset销毁标识符 不能销毁原值 unset只是断开 标识符和指向的内容，引用 刚好是断开前标识符和变量的


###  php  ?? 和 ?: 的区别


$a ?? 0 等同于 isset($a) ? $a : 0。

$a ?: 0 等同于 bool($a) ? $a : 0。

empty: 判断一个变量是否为空(null、false、00、0、'0'、』这类，都会返回true)。

isset: 判断一个变量是否设置(值为false、00、0、'0'、』这类，也会返回true)。


### php的cmd

php -l test.php  检查语法错误


### php扩展安装 

yum search php | grep -i soap


### json_encode 不转义 /
```php
<?php
//不转义 /
json_encode(['xx'=>'\\\\//','ee' => '中国'], JSON_UNESCAPED_SLASHES);
//不转义unicode
json_encode(['xx'=>'\\\\//','ee' => '中国'], JSON_UNESCAPED_UNICODE);
```
