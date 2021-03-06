Redis基础：
Redis支持五种数据类型：string（字符串），hash（哈希），list（列表），set（集合）及zset(sorted set：有序集合)。

*****************************************  string  *******************************************
SET name "bar"
GET name
  // bar

incr key //自增1
decr key //自减1
incrby key k //自增k
decrby key k  //自减k

setnx key value //key不存在才设置 == set key value nx
setxx key value //key存在才设置 (更新) == set key value xx
mset key1 key2 ... //
mget key1 key2 ... //
getset key newvalue //设置新值 返回旧值
append key value //追加(拼接) 返回字节长
strlen key  //获取字节长



******************************************  hash  *******************************************************
HMSET myhash field1 "hello" field2 "world"
HGET myhash field1
HGET myhash field2
HGETALL myhash   获得所有
  //  1)field1
  //  2)hello
  //  3)field2
  //  4)world

HDEL field1 [field2] 删除指定field
HEXISTS key field1   查询是否存在
HLEN myhash          所需field数量
HVAL

hmget key field1 field2 ...
hgetall key

hincrby key field k  //自增k

hvals key //直返field的值
hkeys key //返回field的名称



******************************************  list  ***************************************************


//插入
rpush key value1 value2 ... //从右边插入列表
lpush key value1 value2 ... //从左边

linsert key before|after value newvalue  //在value前或是后插入

//弹出
lpop key //左边弹出元素 key + value 两个值
rpop key //右边弹出元素

//删除
lrem key count value //删除value
     //count < 0 右删count个value
     //count > 0 左删count个value
     //count = 0 全部删除value

ltrim key start end  //修减列表

//获取
lrange key start end(包含end)
lrange key 0 2   //0到2
lrange key 0 -1  //0到最后一个
lindex key 0    //第0个
lindex key -1   //最后一个


//更新
lset key index newvalue 

blpop key timeout //左弹出 为空列表时候 堵塞等待timeout再弹出 timeout=0 一直堵塞 等到有数值 弹出
brpop key timeout //右弹出


****************************************** set ***********************************************

（无序 单一 相互交集api 小心使用）

//增
sadd key element  //存在 返回为0
//删除
srem key element 
//查
scard key //计算大小
sismenmber key element //是否在集合中
srandmember key count //随机取出count个 里面还存在
spop key count //随机弹出count个 里面不存在了
smenmber key //无序返回所有元素

//集合间的使用
sdiff key1 key2 //插集
sinter key1 key2 //交集
sunion key1 key2 //并集
sdiff|sinter|sunion + store destkey #结果保存在destkey

***************************************  zset ****************************************************
//增加
zadd key score element .... //score可以重复 element不能重复
//删除
zrem key element ...//可以删除多个
//获取
zscore key element  //获取元素分数
//自增（负值代表减少）分数
zincrby key number element //增加score 返回增加后的分数

zcard key //返回元素个数
zrand key element //返回所在排名 从0开始遍历
zrang key start end [withscores] //遍历元素 是否查出分数
zrangebyscore key score1 score2 [withscores] //通过分数排名 是否查出分数
zcount key score1 score2 //分数之间有多少个
zremrangbyrank key start end  //删除第几个到第几个排名的删除
zremrangbyscore key score1 score2  //删除第几分到第几分的删除

//补充
zrevrank  zrevrange zrevrangebyscore zinterstore zuninonstore 



################################ 基础redis信息 ###############################################

安装 :
yum install redis

启动 ：
systemctl start redis.service

开机自启 ：
systemctl enable redis.service

配置文件：
/etc/redis.conf 配置文件
    daemonize yes #开机自启
    logfile #日志目录
    dir #工作目录 
    port #端口

>基础api

config get *            #配置信息

config set key value    #临时配置

info [select]           #信息查看

dbsize                  #key的总数
 
keys *                  #遍历所以key 支持正则 得到所有key
                        #热备 或 scan使用

dump key                #打印key的值

exists key              #key是否存在
			                  #返回 0 或 1

del key1 key2 ...       #删除key
			            #返回 删除个数 或 nil

expire key seconds      #设置key在多少秒过期

ttl key                 #剩余秒数  -2不存在key或已过期 -1存在永不过期

type key                # 返回 string hash list set zset nil



#######################################  Redis功能  ###########################################

> 慢查询
 1.生命周期
    发送命令->队列->执行命令->返回结果；
    慢查询发生在第三阶段，
 2.两个配置 (slowlog-max-len=128; showlog-log-slower-than=1000)
    a 先进先出队列 ，固定长度 ，保存在内存中。
    b 慢查询阀值 ， 记录慢查询条数。

> pipeline 流水线
  n+命令 传输到服务端。
  只能作用在一个redis节点。

> 发布订阅
  publish channel message 
  
  subscribe channel ...

  unsubscribe channel ...

> Bitmap 位图
  setbit key offset value //返回覆盖前的值
  getbit key offset        //0或1  不存在则0
  bitcount key [start end] //直接为1的个数
  bitop {op} {destkey}    // and交集 or并集 not非 xor异或
  bitpos key targetBit [start end]   //
 

 > HypeerLogLog (本质string)
   pfadd key element ...  //添加数据统计
   pfcount key //返回元素总数 element唯一性
   pfmerge key_new key1 key2 //合并新的

 > GEO (本质string)
   geoadd key lon lat member ...//添加  geoadd place 116.28 39.5 beijing 115 33.8 xxx 
   geopos key member ... //获取
   geodist key member1 member2 [unit] //计算距离 m|km|mi|ft

   //通过经纬度范围查询
   georadius key lon lat radiu m|km|ft|mi [withcoord] [withdist] [withhash] [COUNT count] [asc|desc] [store key]  [storedist key]
   //通过member查询
     georadiusbymember key member radiu m|km|ft|mi [withcoord] [withdist] [withhash] [COUNT count] [asc|desc] [store key]  [storedist key]

    //radiu 距离 ft尺 mi英里

   //withcoord 结果是否包含经纬度
   //withdist 结果是否包含距离中心位置的距离
   //withhash 结果中包含geohash
   //COUNT count 指定返回结果的数量
   //asc|desc 距离中心位置的升序或降序排列
   //store key 返回结果保存到指定的key中
   //storedist key 返回结果距离中心节点的距离保存到指定键


##################################### redis 持久化 #################################################

 > RDB [快照]
  1.机制生成RBD文件(二进制) 
  2.触发机制
    a. save命令 同步执行 堵塞
       会覆盖老的RDB文件 
    
    b. bgsave命令 异步执行
       fork子进程执行命令
    
    c. 自动
       配置文件  seconds changes  
       save      900      1
       save      300      10
       save      60       10000

       dbfilename dump.rdb //生成文件
       dir ./ 默认当前目录
       stop-writes-on-bgsave-error yes //错误是否停止写了
       rdbcompression yes //是否压缩
       rdbchecksum yes //是否检验

       最佳配置：
       dbfilename dump-${port}.rdb
       dir /xxx

       其他触发机制：
       全量复制。
       debug reload。
       shutdown。

 > AOF [日志][级别更高]
  1.原理 把命令追加到aof文件
  2.aof策略
    a. always 
       写命令刷新到缓冲区，每条命令都写到aof文件
    b. everysec
       缓冲区，每秒fync到硬盘 (默认每秒) 可能丢失秒级别数据
    c. no
       系统决定
  3.aof重写
    a. 作用
       减少占用量及加卡恢复速度
    b. bgrewriteaof (命令 异步)
       fork子进程 从内存回溯数据成命令
    c. 配置文件
       auto-aof-rewrite-min-size  重写aof需要的大小
       auto-aof-rewrite-percentage aof文件增长率
       aof-current-size 当前尺寸
       aof-base-size 上次重写尺寸
    d.使用
      appendonly yes 开启aof
      appendfilename "appendonly-${port}.aof" 文件名
      appendfysync everysec                   每秒开启
      dir /xxx                                路径
      no-appendfsync-on-rewrite yes           
      auto-aof-rewrite-min-size 64m
      auto-aof-rewrite-percentage 100




################################## redis主从复制 ###################################################

  命令server-cli:  slaveof ip port 建立连接(异步复制) 在redis执行 slaveof ip port  会把已经有的数据清除
                   slaveof no one 关闭同步

  配置文件:        slaveof ip port
                   slave-read-only yes //从节点数据只读

  
  命令info replication： 
                  master_repl_offst偏移量
                  run_id 服务器的唯一id

  全量复制：
          master->rdb文件(通过偏移量对比)->slave
  
  开销：
        bgsave 时间
        RDB网络传输
  
  部分复制：
        复制抖动(连接断开过)
  
  故障处理：
        高可用服务。

  开发运维：
        读写分离问题： 复制数据延迟
                      读取数据过期
                      从节点故障
        主从配置不一致：  

        规避全量复制：第一次不可避免
                     run_id变化
        规避风暴： 


######################################### sentinel ######################################################

Redis Sentinel 默认port 26379
     主从复制高可用的问题：手动解决问题
     架构：redis主从结构 + sentinel节点
      客户端 ->sentinel ->redis-master + redis-slave
     
     故障转移：
         sentinel故障发现 转移 通知客户端； 

     安装配置：
        redis 主从jiedian
        配置 sentinel节点 特殊的redis节点
        多台机器配置
        #主
        redis-server redis-7000.conf
          port 7000
          daemonize yes
          pidfile /var/run/redis-7000.pid
          logfile "7001.log"
          dir "/opt/soft/redis/data"
        #从
        redis-server redis-7001.conf          
          ....

        #sentinel
          port 26379
          daemonize yes
          dir /opt/soft/redis/data
          logfile 26379.log
          sentinel monitor mymaster 127.0.0.1 7000 2  #监控的主节点 7000端口 2代表2sentinel发现问题才故障转移
          sentinel down-after-milliseconds mymaster 30000  #监控出错的数据 3000ms
          sentinel parallel-sycs mymaster 1
          sentinel failover-timout mymaster 180000

        启动 reids-sentinel redis-sentinel.conf
             info 查看信息


        客户端实现：

        sentinel-k => sentinel => get-master-addr-by-name "masterName" =>获取master节点

                   => role 或 role replication

        通过发布订阅实现sentinel监听master地址变化。

        日志文件：sentinel日志

        三个日志任务：每十秒sentinel对master和salve执行info  发现slave节点  确认主从关系
                     每两秒通过master节点的channel交换  publish+subscribe
                     每一秒sentinel对其他sentine和redis进行ping

        主观下线和客观下线：
                    sentinel monitor <mastername> <ip> <port> <quorum>
                    
                    sentinel down-after-milliseconds <mastername> <timeout>
                     timeout 是主观下线判断依据

                    sentinel is-master-dowm-by-addr
                       1 交换意见 quorum统一认识的个数 是客观下线依据
                       2 领导者选举  
                    


#################################### Redis Cluster #########################################
      
      呼唤集群：

      数据分布：

      搭建集群：

      集群伸缩：

      客户端路由：

      集群原理：

      常见问题：

