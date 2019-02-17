tail -f /tmp/date.txt  #实时更新
tail -3 /tmp/date.txt  #最后三行
tail -n 10 xxx          最后10行
date +%w               #返回星期几
test 1 = 0             #测试语句
echo $?                #返回最后一个语句生成的值
cat /proc/cpuinfo      #查看cup
fdisk  -l              #查看硬盘
ifconfig -a            #查看网卡

#更换root密码
sudo passwd

# 查看linux版本号
cat /proc/version
uname -a
cat /etc/redhat-release

lsb_release -a


# 安全selinux
setenforce 0 //关闭
setenforce 1 //开启


#查看进程
ps aux|grep server.php        #查看进程
pstree -ap|grep server.php    #查看进程树

ps auxw|head -1;ps auxw|sort -rn -k3|head -10  # 查看cup占大的进程

ll /proc/进程号               #通过进程号查看进程信息       

## kill命令
kill -l    所有信号
以下为中断信号：
    HUP     1    终端断线
    INT     2    中断（同 Ctrl + C）
    QUIT    3    退出（同 Ctrl + \）
    TERM   15    终止
    KILL    9    强制终止
    CONT   18    继续（与STOP相反， fg/bg命令）
    STOP   19    暂停（同 Ctrl + Z）

kill -SIGUSR1 7259  #重启配置文件

#端口查看
lsof -i:9505
netstat -anp|grep 9505
netstat -luntp|grep 80   #查看监听端口
      -a (all)显示所有选项，默认不显示LISTEN相关
      -t (tcp)仅显示tcp相关选项
      -u (udp)仅显示udp相关选项
      -n 拒绝显示别名，能显示数字的全部转化成数字。
      -l 仅列出有在 Listen (监听) 的服務状态

      -p 显示建立相关链接的程序名
      -r 显示路由信息，路由表
      -e 显示扩展信息，例如uid等
      -s 按各个协议进行统计
      -c 每隔一个固定时间，执行该netstat命令。

#tar命令 [x,c指令必须放到开头]
tar -xzvf file.tar.gz              -C  /tmp/ #指定解压目录      -c打包 -x解包 -v显示过程 -f指定打包后名
tar -xjvf file.tar.bz2

#zip
unzip xxx.zip 解压
zip -r xxx.zip xxx  打包

#rar
rar -x file.rar 

#编译安装
./configure
make
make install
make test       #测试是否完成安装

#文件命令
cp  xxx.tar.gz  /usr/local/    #复制文件
mv  *.php  1/                  #移除文件到1下*****
mv  1.txt  1.html              #重名
rm  -rf   1.html               #强制删除

#swoole编译安装
phpize                                #关联到PHP拓展库
/*
 7以上 需要的扩展
yum -y install php70w-devel



*/

./configure   --enable-async-redis    #启用异步redis  需要安装hiredis  C客户端的支持

/*
configure 出错
：出现该情况是由于c++编译器的相关package没有安装，在终端上执行：
　　$ sudo yum install glibc-headers gcc-c++
*/


pcre库的依赖
    ubuntu/debian环境://apt-get install libpcre3 libpcre3-dev
    centos/redhat环境://yum install pcre-devel
    
make                                  #编译
sudo make install                     #编译安装

#find 查找
find / -name nginx*                   #匹配所有nginx的目录以及文件

#vim
命令行模式：
   
    dd  删除所在行
    3dd 删除3行
    d$  将所在行置为空白
     
    
    yy  复制所在行
    3yy 复制3行
    p   粘贴
    
    
    u   撤销
    ctrl+r	撤销更改
    
    0  单行行首
    gg 文件首
    G  文件尾
    
    
输入模式：
    :set nu   设置行号
    :set nonu 取消行号
    :2        跳到第几行
    :!        外部命令
    /xx       查找xx  按n查找下一处
    ?xx       反向xx  查找上一出
编辑模式：
  
  
 #软链接
 ln -s /a  /b
 

#
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

# sftp scp 
get filename
put filename  /root/
scp -r root@192.163.0.1:/root/to_copy /root/after_copy/  #从服务器靠过来
scp -r /root/local  root@192.163.0.1:/root/test          #本地拷到服务器



