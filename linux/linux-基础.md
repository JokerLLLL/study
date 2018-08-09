mkdir -p /fafd/fafd/afio     递归创建
cp -a /fadfa/fadsf  /gca/fa  递归复制
locate xxx.php               搜索(索引一天一更)  配置文件/etc/updatedb.conf  
whereis xxx					 查询命令位置   -b查执行文件 -m只查帮助文件
echo $PATH					 环境变量
find / -name joker*          查找文件
find /home -mtime +10        10天前修改的文件
find /home -size 25k         >25k的文件

mount	  挂载
fdisk  -l 查看硬盘
echo -e   解析转移符    echo -e "\e[1;33mXXX\e[0mxxx"
alias ls='ls --color=never' 别名

快捷键::
ctrl+a  ctrl+e  ctrl+u 到前 到后 清空

>log.txt 覆盖
>>log.txt 追加

wc [-cwl] [文件名]   -c字节 -w单词 -l行数

输入重定向
wc -l <xx.txt

umask  创建文件权限 换算成读写执行相减 666-022  777-022

echo $? 上条命令是否真确执行 0 为正确

awk编辑器

#快速编辑去除 空白和#注释的配置文件
cat xx.conf|grep -v "^$"|grep -v "#">>xx3.conf

ls -lh 查看文件大小

#查看端口
netstat -anp|grep 9000

#ab压力测试
ab -n 1000 -c 20 htts://www.baidu.coom/

#curl 查看请求头
curl -v www.baidu.com >> /dev/null

#openssl 证书生成
openssl req -x509 -newkey rsa:2048 -nodes -sha256 -keyout server-private.pem -out server-cert.pem

