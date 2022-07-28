
#array_merger 和 + 的区别 
1. 当下标为数值时，array_merge()不会覆盖掉原来的值，但array＋array合并数组则会把最先出现的值作为最终结果返回，而把后面的数组拥有相同键名的那些值“抛弃”掉（不是覆盖）. 
2. 当下标为字符时，array＋array仍然把最先出现的值作为最终结果返回，而把后面的数组拥有相同键名的那些值“抛弃”掉，但array_merge()此时会覆盖掉前面相同键名的值. 

+ 前面的不动，后来者往里加。 merger 后来者居上，数字下标重写

e.g:
```php

$a = [
	'abc' => 'aaa'
];

$b = [
	'abc'=>'bbb'
];

var_dump($a + $b);
var_dump(array_merge($a,$b));

array(1) {
  ["abc"]=>
  string(3) "aaa"
}
array(1) {
  ["abc"]=>
  string(3) "bbb"
}
---------
$a = [
	'999' => 'aaa'
];

$b = [
	'999'=>'bbb'
];

var_dump($a + $b);
var_dump(array_merge($a,$b));

array(1) {
  [999]=>
  string(3) "aaa"
}
array(2) {
  [0]=>
  string(3) "aaa"
  [1]=>
  string(3) "bbb"
}

```


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
https://www.php.net/manual/zh/control-structures.foreach.php  
```
$arr = array(1, 2, 3, 4);
foreach ($arr as &$value) {
    $value = $value * 2;
}
var_dump($arr);
// 现在 $arr 是 array(2, 4, 6, 8)

// 未使用 unset($value) 时，$value 仍然引用到最后一项 $arr[3]

foreach ($arr as $key => $value) {
    // $arr[3] 会被 $arr 的每一项值更新掉…
    echo "{$key} => {$value} ";
    print_r($arr);
}

$value = 'xx';
var_dump($arr);
unset($value);
var_dump($arr);
```

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

## nowDoc hereDoc

```
$nowDoc =  <<<'now'
$var
now;

$hereDoc = <<<here
$var
here;
```


## PHP中的比较运算符有点诡异，很容易出错，现列出比较规则：

1、当两个字符进行大小比较时，是比较着这两个字符的ASCII码大小——这条很容易理解。

2、当两个字符串进行大小比较时，是从第一个字符开始，分别比教对应的ASCII大小，只要从从某个对应位置开始，其中一个字符串的当前位置字符大于另一个字符串对应位置字符，即直接判别出这两个字符串大小，如'ba'>'az'——这条其实大家也都知道的。

那么'10'与'a'比较呢，当然还是一样的啦，首先将'1'和'a'ASCII码进行比较，'a'大。

3、当一个数字与一个字符串/字符进行大小比较时，首先系统尝试将此字符串/字符转换为整型/浮点型，然后进行比较，如'12bsd'转型为12，'a'转型为0，千万需要注意的是此时不是将其对应的ASCII码值与数字进行大小比较了。

其实同样的道理，'a'+10结果也是10。

并且容易忽略的：0 与任意不可转化为数字的字符串比较(操作符为==), 均返回 true。

最后就会出现如下结果：

1 var_dump('1000000'<'a');    //result: boolean true
2 var_dump('a'<1);            //result: boolean true
3 var_dump(1<'1000000');      //result: boolean true