#! /bin/bash

# 针对 ${}的说明 https://www.cnblogs.com/chengd/p/7803664.html

# If the script is sourced by another script
if [ -n "$BASH_SOURCE" -a "$BASH_SOURCE" != "$0" ]
then
    do_something
else # Otherwise, run directly in the shell
    do_other
fi

# https://www.cnblogs.com/sunfie/p/5943979.html 针对$BASH_SOURCE的说明


## EOF 的用发 https://www.jianshu.com/p/df07d8498fa5

## 重定向说明 &>file 1>&2  https://blog.csdn.net/huangjuegeek/article/details/21713809
## &> 等同 1&2>  //  >&2 等 1>&2


cat <<DOC
1 $1是函数的第一个参数
2 看替换的定义，${varname:-word}，如果varname存在且非null，则返回其值；否则，返回word。用途：如果变量未定义，则返回默认值。
3 上述替换中的word是空，即，如果1没有定义，就返回空

所以，${1:-}的意思就是说，如果函数有第一个参数，就返回这个参数，如果没有，就返回空。

其实我们平常都不写得这么麻烦，就直接说 [ -n "$1" ],这个脚本写成这个样子，大概是为了严谨？我学习一下先，说不定还真是我遗漏了什么。
DOC


if [ -n "${1:-}" ]
then
    do_st
fi

## if [ -n ] 的正确用法 https://www.cnblogs.com/ariclee/p/6137456.html


## $$ $0 $2 ...的含义 https://www.cnblogs.com/viviane/p/11101643.html


## shell的getopts命令 https://www.jianshu.com/p/baf6e5b7e70a