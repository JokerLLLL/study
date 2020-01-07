## 查找文件出现的字符串

find src -name "*php" | xargs grep "subMark" --colour --line-number

## find的其命令

find / -name joker*          查找文件
find /home -mtime +10        10天前修改的文件
find /home -size 25k         >25k的文件
find . -name '*.zip' -print0 |xargs -n1 -0 unzip  // 可以过滤 ' ' xargs 分组 1 进行使用