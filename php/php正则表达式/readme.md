## 网址
PHP 正则表达式 - 简书
https://www.jianshu.com/p/fed457ee8a6c 
表达式检查
https://regexr.com/
文档
https://tool.oschina.net/uploads/apidocs/jquery/regexp.html


##　原子

正则支持unicode匹配　\t \n  代表tab和回车

原子: 最小单元, 可见(a,aa, 陈...), 不可见原子(\t, \n ...) 自定义原子([A-Z],[a-z0-9],[abc])取其中的一个原子
[abc] 匹配，a或b或c
[^abc] 取反，不匹配a或b或c

特殊的原子：
\d === [0-9]
\D === [^0-9]
\w === [0-9a-zA-Z]
\W === [^0-9a-zA-Z]
\s === [\n\f\r\t\v]
\S === [^\n\f\r\t\v]

##　元字符

 . 匹配换行符所有字符 ！！！！不匹配换行符

 | 选择分支 /a|b/ === /[ab]/
 
## 边界限制符

^ 匹配行头 ！！！行头
$ 匹配行尾 ！！！行尾
\b 英文单词边界
\B 非单词边界

## 量词

*  重复 >= 0
+  重复 > 0
?  重复 1 次
{n} 重复次
{n,} n到多
{n,m} n到m


##　贪婪

禁止贪婪 禁止贪婪

?跟在量词后面 /abc.*?/ 

修正模式/abc.*/U

## 模式单元

(abc|bbc|aaa) 变成了三个基本单元 并捕获文本 可以进后续使用


## 反向引用

筛选叠字 通过模式单元
/([\u4e00-\u9fa5])\1/  // 汉字叠字 反向引用 
捕获的文本放在缓冲区，缓冲区的编号1-99，反向引用格式为 \n (n = {1~99})

非捕获元字 ?: （就是不能用于反向引用）
e.g:
/123(\d{2})(\d{2})(\d{2})\1/  捕获三个模式单元 并且重复第一个单元用于匹配

/123(?:\d{2})(\d{2})(\d{2})aa\1/ 捕获俩个模式单元并重复捕获的第一个


## 定界符

定界符： #xxx# /xxx/ ~xxx~ 等

## 模式修正

U ：禁止贪婪
i ：忽略大小写
x ：忽略文本内容的空白 
s ：将字符串是为单行，.也能匹配换符号
m ：将字符串视为多行，^ 和 $ 匹配行首和行尾


e.g: 匹配ff和xx开头两行开头的内容
/^ff.*^xx/msU
```text
ff yyyyyyy....
.......这里是匹配的内容
.....
xx----
ff yyyyyyy....
.......这里是匹配的内容
.....
xx---
ff ooooooooo....
..这里匹配不上
99xx
```

### \w 

PS:下面看下正则表达式 \w \s \d \b

. 匹配除换行符以外的任意字符

\w 匹配字母或数字或下划线或汉字 等价于 '[^A-Za-z0-9_]'。

\s 匹配任意的空白符

\d 匹配数字

\b 匹配单词的开始或结束

^ 匹配字符串的开始

$ 匹配字符串的结束

### 匹配 表符号
### 多码位表情包

php的不同点 u模式： 
https://www.php.net/manual/zh/reference.pcre.pattern.modifiers.php
http://www.shtml.net/article/content/tok/27347/id/253823.shtml
https://www.5axxw.com/questions/content/4cle8y
https://blog.csdn.net/qq_36380426/article/details/108016275

/[\x{10000}-\x{10FFFF}\x{FFFD}\x{003F}].*/u
