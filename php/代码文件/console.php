<?php

/** console输入
 * @param string $info
 * @return string
 */
function getArgument($info = 'please input your value:')
{
    fputs(STDOUT,$info);
    return trim(fgets(STDIN));
}

getArgument();
getArgument();

/**
 * 说明
 * \r   回车 即:将当前位子回溯到最左
 * \n   换行 即：将当前位置下拉到下一行
 * \r\n
 *
        Windows系统中有如下等价关系：
        用enter换行 <====> 程序写\n  <====> 真正朝文件中写\r\n(0x0d0x0a) <====>程序真正读取的是\n
        linux系统中的等价关系：
        用enter换行 <====> 程序写\n  <====> 真正朝文件中写\n(0x0a)  <====> 程序真正读取的是\n
 *
 */