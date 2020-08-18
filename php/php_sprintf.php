<?php
/**
 *
 * url: https://www.cnblogs.com/bushuo/p/5657730.html
 *
 * 本文实例讲述了PHP中sprintf函数的用法。分享给大家供大家参考。具体用法分析如下：
sprintf()函数在php官方是说把字符串格式化输出了,本文就来给各位朋友介绍一下在学习sprintf()函数时的一些经验分享,希望能给大家带来帮助.
PHP函数 sprintf() 函数官方定义为：sprintf():把格式化的字符串写入一个变量中
语法为:sprintf(format,arg1,arg2,arg++);
参数:
format:必须，转换格式
arg1 :必须，规定插入 format 字符串中第一个%符号处的参数
arg1 :可选，规定插入 format 字符串中第二个%符号处的参数
arg1++:可选，规定插入 format 字符串中第三、四等%符号处的参数
参数 format 的转换格式,以百分比符号（%）开始到转换字符结束,下面是有可能的format值.
%% – 返回百分比符号
%b – 二进制数
%c – 依照 ASCII 值的字符
%d – 带符号十进制数
%e – 可续计数法（比如 1.5e+3）
%u – 无符号十进制数
%f – 浮点数(local settings aware)
%F – 浮点数(not local settings aware)
%o – 八进制数
%s – 字符串
%x – 十六进制数（小写字母）
%X – 十六进制数（大写字母）
 */
$c="1234";

// %   '（补位值） 宽度值  格式化类型  这三部分
echo sprintf("%'x13.2f", $c);
//  补：'x 长度：13.2 格式：f  效果为：xxxxxx1234.00

echo sprintf("%'07s", $c);
//结果是：0001234

echo sprintf("[%-6s]",$c);       //结果是：[1234 ]

echo sprintf("[%-4s]",$c);       //结果是：[1234]

echo sprintf("[%4.2s]",$c);       //结果是：[ 12]