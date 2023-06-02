# wamp msql设置日志：
01.打开 Mysql控制台
02.查看 general_log 状态：SHOW VARIABLES LIKE '%general_log%';确认 log记录档在何处。
03.打开 general_log 监看：SET GLOBAL general_log = 'ON';执行网站 ，看 log记录档，执行了那些SQL语句。
04.关闭 general_log 取消监看:SET GLOBAL general_log = 'OFF';


//设备批量查询日志里的  最新或最旧的消息 

# 列里 嵌套列表(或分组后端前三条)
$sql = "SELECT * from band_step where id in
     (SELECT  max(id) from band_step where MID in (\"{$deviceList2}\") GROUP BY MID)";  //max 时间可能重复 in id解决 不然子查询和外查询都要加 in deviceList条件 还要group by


e.g. <<< 该例子 不不严谨 查询慢。 cat_id 分组 每个分组 价格最高前两条 （坑：若果第二和第三....一样就会造成都查出来）
 SELECT a.* FROM `mygoods` as a 
     WHERE  
     (SELECT COUNT(*) FROM `mygoods` WHERE cat_id = a.cat_id AND price > a.price ) < 2 //判断这个分组的前面数据是<2的 
     ORDER BY a.cat_id asc ,a.price DESC 
说明： 



# 字段裁切

MySQL 字符串截取函数：left(), right(), substring(), substring_index()。

select left(create_time,13) as atime form member; 



# mysql 的事务锁
```sql
    //设置事务不自动提交 开始事务 查询数据 并将该数据锁定 （锁定数据只能自读 不能修改删除）
    SET AUTOCOMMIT=0; BEGIN WORK; SELECT quantity FROM products WHERE id=3 FOR UPDATE; 
    
    //判断
    
    //然后操作 进行事务提交
    UPDATE products SET quantity = '1' WHERE id=3 ; COMMIT WORK;
    
```
上面介绍过SELECT ... FOR UPDATE 的用法，不过锁定(Lock)的数据是判别就得要注意一下了。
由于InnoDB 预设是Row-Level Lock，所以只有「明确」的指定主键，MySQL 才会执行Row lock (只锁住被选取的数据) ，
否则MySQL 将会执行Table Lock (将整个数据表单给锁住)[严重影响效率]。

//锁表情况 比如 select * where name = `joker` for update; 会导致整张表锁死

FOR UPDATE 仅适用于InnoDB，且必须在事务区块(BEGIN/COMMIT)中才能生效。


# 字符串链接
```sql
UPDATE hy_brand set `logo` = CONCAT('http://obd-admin.com/brand_logo/',`logo_bp`);

```

CONCAT(null, '_99999')  === null

## 查询不是空表的表名

```sql
select * from information_schema.tables where TABLE_SCHEMA='当前数据库' and table_rows>0;
```

# mysql  查询重复

```sql

select * from order_notice  where id in (select id from order_notice where uid = :uid group by end_time having count(id) > 1);

// 正确示例
select * from order_notice p1 WHERE (p1.uid,p1.end_time) in (SELECT uid,end_time from order_notice group by uid,end_time HAVING count(*) > 1);


// 不需要最小值的重复数据
SELECT * FROM order_notice WHERE (uid,end_time) IN (SELECT  uid,end_time FROM order_notice GROUP BY uid,end_time HAVING  COUNT(*) > 1) AND id NOT (SELECT MAX(id) FROM order_notice GROUP BY uid,end_time HAVING COUNT(*) >1);

```

```sql
// n2级别的排序  不可取  //而且重复数据 id会重复  错误事例  ！！！
!SQLERROR: select p1.* from order_notice p1, order_notice p2 where p1.id <> p2.id and p1.end_time = p2.end_time and p1.uid = p2.uid;

```


// 重复都查询出来
```sql
EXPLAIN SELECT a1.* FROM `user` as a1 WHERE (SELECT count(*) FROM `user` WHERE phone = a1.phone) > 1;
```



// 磁盘大小用量统计

```sql
# 统计单张表
select 
    (data_length+index_length)/1024/1024 M 
from 
    information_schema.tables 
where 
    table_schema="db_name" and table_name='table_name';

#查看整个数据库的磁盘用量
select 
    sum((data_length+index_length)/1024/1024) M
from 
    information_schema.tables 
where 
    table_schema="db_name" ;


#查看整个mysql server 所有数据库的磁盘用量
select 
    table_schema, sum((data_length+index_length)/1024/1024) M
from 
    information_schema.tables 
where 
    table_schema is not null 
group by 
    table_schema;


```

##  查看所有数据库(指定)容量大小 / 查看所有数据库(指定)各表容量大小
## https://www.cnblogs.com/daniel2021/p/10670291.html
```sql
SELECT
	table_schema AS '数据库',
	sum( table_rows ) AS '记录数',
	sum( TRUNCATE ( data_length / 1024 / 1024, 2 ) ) AS '数据容量(MB)',
	sum( TRUNCATE ( index_length / 1024 / 1024, 2 ) ) AS '索引容量(MB)' 
FROM
	information_schema.TABLES 
GROUP BY
	table_schema 
ORDER BY
	sum( data_length ) DESC,
	sum( index_length ) DESC;


SELECT
	table_schema AS '数据库',
	table_name AS '表名',
	table_rows AS '记录数',
	TRUNCATE ( data_length / 1024 / 1024, 2 ) AS '数据容量(MB)',
	TRUNCATE ( index_length / 1024 / 1024, 2 ) AS '索引容量(MB)' 
FROM
	information_schema.TABLES 
WHERE
	table_schema = 'oms-test' 
ORDER BY
	data_length DESC,

```

## 查库大小
select 
table_schema as '数据库',
sum(table_rows) as '记录数',
sum(truncate(data_length/1024/1024, 2)) as '数据容量(MB)',
sum(truncate(index_length/1024/1024, 2)) as '索引容量(MB)'
from information_schema.tables
group by table_schema
order by sum(data_length) desc, sum(index_length) desc;

## 查表大小
select 
table_schema as '数据库',
table_name as '表名',
table_rows as '记录数',
truncate(data_length/1024/1024, 2) as '数据容量(MB)',
truncate(index_length/1024/1024, 2) as '索引容量(MB)'
from information_schema.tables 
where table_schema='oms_elc'
order by data_length desc, index_length desc;

-- 更新分析(information_schema有缓存)
ANALYZE TABLE Message,Intercept;

-- 命令分析

```
Use 

mysqlcheck -Aa -uroot -p 

to run analyze table for all databases and tables (including InnoDB) on a running server. Available in MySQL 3.23.38 and later.

mysqlcheck命令参数说明：

-A, --all-databases Check all the databases. This will be same as
                    --databases with all databases selected.
-a, --analyze       Analyze given tables.

```



#中间表

```sql
UPDATE Queue 
SET isProcessed=1, isDeleted = 1
WHERE
    id IN (
SELECT
    a.id 
FROM
    (
SELECT
    q.id 
FROM
    `Queue` q
    LEFT JOIN SalesOrder AS s ON q.entityId = s.id 
WHERE
    q.mark = 'TMS_DELIVERY_CHECKING' 
    AND q.queueType = 'SALESORDER' 
    AND q.isProcessed = 0 
    AND s.preferredDeliveryCompany NOT IN (
    'guo_xiao',
    'ems_kdbg',
    'jing_ji',
    'ems',
    'quan_feng',
    'yuantong',
    'sf_ruitai',
    'you_su',
    'zhongtong',
    'huitong',
    'shentong',
    ' zhaijisong',
    'yun_da',
    'shun_feng',
    'kuaijie',
    'sf_weixiao' 
    ) 
    ) AS a 
    )
```


## mysql 的 0000-00-00 00:00:00 报错 Incorrect datetime value

https://blog.csdn.net/zha_stef/article/details/83990625
https://www.cnblogs.com/huanhang/p/7050757.html

```sql
show variables like "sql_mode"

set global sql_mode=""; // all us

set global sql_mode="ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION"; -- 源数据

set global sql_mode="ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION";

set global sql_mode="STRICT_TRANS_TABLES,STRICT_ALL_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER"; -- 设置后数据

```
sql好像不起做用：

直接 my.cnf 设置： sql_mode=STRICT_TRANS_TABLES,STRICT_ALL_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER


### mysql 的OPTIMIZE optimize

来看看手册中关于 OPTIMIZE 的描述：

OPTIMIZE [LOCAL | NO_WRITE_TO_BINLOG] TABLE tbl_name [, tbl_name] ...

如果您已经删除了表的一大部分，或者如果您已经对含有可变长度行的表（含有VARCHAR, BLOB或TEXT列的表）进行了很多更改，则应使用
OPTIMIZE TABLE。被删除的记录被保持在链接清单中，后续的INSERT操作会重新使用旧的记录位置。您可以使用OPTIMIZE TABLE来重新
利用未使用的空间，并整理数据文件的碎片。

https://blog.csdn.net/sanbingyutuoniao123/article/details/77839053 -- optimize报错
https://blog.csdn.net/YABIGNSHI/article/details/52297188           -- Table does not support optimize, doing recreate + analyze instead
https://blog.csdn.net/yabingshi_tech/article/details/52274990      -- truncate table tablename;

```sql

SHOW INDEX FROM Config;

DELETE FROM Config WHERE id < 5000;

SHOW INDEX FROM Config;

OPTIMIZE TABLE Config;

SHOW INDEX FROM Config;

```

### mysql 事务

https://books.google.co.jp/books?id=s8PUDwAAQBAJ&pg=PT233&lpg=PT233&dq=mysql+%E4%BA%8B%E5%8A%A1%2Brename+table&source=bl&ots=p5-TycX_Ia&sig=ACfU3U2FUGMCKxOOxIDlMMNBtj2hI5jRYw&hl=zh-CN&sa=X&ved=2ahUKEwiS8Zeo66_pAhUOa94KHZl2B1YQ6AEwCXoECAoQAQ#v=onepage&q=mysql%20%E4%BA%8B%E5%8A%A1%2Brename%20table&f=false


### mysql 更新查询

https://www.jianshu.com/p/60b3f987c477
UPDATE PrepackPlatform Left 

JOIN Product ON Product.id = PrepackPlatform.productId 

SET isEnable = 0 

WHERE  Product.productCode in ('');


## mysql实现乐观锁

https://www.cnblogs.com/richerdyoung/p/6427668.html


## 查卡主的sql
show full processlist

## Mysql中length()、char_length()的区别。

a）、length()： 单位是字节，utf8编码下,一个汉字三个字节，一个数字或字母一个字节。gbk编码下,一个汉字两个字节，一个数字或字母一个字节。
b）、char_length()：单位为字符，不管汉字还是数字或者是字母都算是一个字符。

## like unicode sql

select * FROM ApiAction WHERE id > 678246 and id < 778246 and  `data` like  '%_u975e_u5e38_u62b1_u6b49_u56de%';


### v8.0 客户端链接报错


报错信息：
```
'caching_sha2_password' cannot be loaded
```

https://www.jianshu.com/p/939eb5157e83

mysql -u root -p

mysql -h 127.0.0.1 -u root -p -P 3306

use mysql;
select user,plugin from user where user='root';
alter user 'root'@'localhost' identified with mysql_native_password by 'password';
alter user 'root'@'%' identified with mysql_native_password by 'password';
（发现两个 root账号。）

 -- 立即生效
flush privileges; 


##  由mysql的 datetime 类型字段默认设置为了'0000-00-00' 引发的血案

https://my.oschina.net/u/2457218/blog/639886

select @@sql_mode;

SET GLOBAL sql_mode = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';

去除 ERROR_FOR_DIVISION_BY_ZERO,NO_ZERO_DATE,NO_ZERO_IN_DATE; 的设置

```
select @@sql_mode;
SET GLOBAL sql_mode = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION';
flush privileges; -- 立即生效??
```

mysql ONLY_FULL_GROUP_BY 配置报错
```
报错：
SET GLOBAL sql_mode = 'NO_ENGINE_SUBSTITUTION';

```
https://blog.csdn.net/yalishadaa/article/details/72861737

STRICT_TRANS_TABLES 严格模式
过长自动截断
not null 设置默认值

### 修改密码

```sql
set password for chenchaoliang@localhost = password('vUg1zK_X33o47QiW3INwFwpcZcFiR3Ha111'); 
ALTER USER USER() IDENTIFIED BY 'vUg1zK_X33o47QiW3INwFwpcZcFiR3Ha';
```

### 前置类型转换造成的数据发现查的sql不对
```sql
-- find出来的数据是 id = 546 的数据 
select  * from  ReturnFacotryOrder where  id = '546-1'; 
```

### GROUP函数group_concat

```sql
SELECT
	so.STATUS,
	count( * ),
	group_concat( so.id ),
	group_concat( sh.id ) 
FROM
	SalesOrder so
	JOIN Shipment sh ON so.id = sh.SalesOrderId 
	AND sh.STATUS <> 3
	LEFT JOIN ShipmentExternal se ON se.shipmentId = sh.id 
WHERE
	so.STATUS IN ( 6 ) 
	AND so.paymentTime > '2021-11-01' 
	AND so.warehouse = 10960 
	AND se.expectedProcessDispatchTime IS NULL 
GROUP BY
	so.STATUS;
```

### not empty

```sql
select * from QueueBetter where not isProcessed;
```


### CASE END用法

```sql
select 
s.id, 
s.salesOrderId,
s.`status`,
s.advanceOrderId,
case s.status when 1 then '已发货' when 2 then '配货中' when 3 then '已取消' else '' end,
s.advanceStatus,
 case s.advanceStatus 
   when 3 then '已取消' 
   when 5 then '已下载' 
   when 7 then '等待通知发货' 
   when 8 then '已通知发货' 
   when 9 then '已发货' 
   else '非前置' 
 end
from Shipment s where s.id in (1,2,2,3);

```


```sql
SELECT
	count( s.id ),
CASE
   
	WHEN `status` = 1 THEN
	'状态1' 
	WHEN `status` = 2 THEN
	'状态2' 
END `statusName`, 
	s.`status` 
FROM
	Shipment s 
WHERE
	s.id IN ( "1422930835", "1422900715", "1422889060", "1422864991" ) 
GROUP BY
	s.`status`;
	
	------------
	
SELECT
	count( s.id ),
	    '表达式1' = 
CASE
	WHEN `status` = 1 THEN
	'状态1' 
	WHEN `status` = 2 THEN
	'状态2' 
END `statusName`, 
	s.`status` 
FROM
	Shipment s 
WHERE
	s.id IN ( "1422930835", "1422900715", "1422889060", "1422864991" ) 
GROUP BY
	s.`status`
	
	
	
```

## 锁表
```sql
lock tables ChanelInventory write;
select * from ChanelInventory limit 10;
insert into ChanelInventory(id,scheduleTime) VALUES(null,'2021') ;
unlock tables;
```

### 8.0 更新json
```sql

update MockOrder set body = json_replace(body,'$.getCiphertextRecipientMobile', 'aaa','$.getCiphertextRecipientName', 'bbb', '$.getCiphertextAddress', 'ddd') where id = 1;
```

## 设置当前可重复读
```sql
SET session transaction isolation level REPEATABLE READ;
```


### mysql的upsert的实现
https://www.jianshu.com/p/b9b7f2b5db24
`ON DUPLICATE KEY UPDATE`
https://www.cnblogs.com/innocenter/p/12869158.html

## join update

```text
UPDATE QueueBetter a
INNER JOIN Shipment b ON b.salesOrderId = a.extraInfo
SET a.entityId = b.id,
 a.isProcessed = 0
WHERE
        a.entityId = 0
AND a.mark = 'getWaybill'
AND a.extraInfo != '';
```

## select insert

INSERT INTO `QueueBetter`(`entityId`, `mark`, `tryTimes`, `isProcessed`, `isDeleted`, `created`, `updated`, `entityName`, `errMsg`, `priority`, `subMark`, `extraInfo`) 
select s.id as entityId,'decryptSensitiveSalesOrder' as mark,0 as tryTimes, 0 as isProcessed, 0 as isDeleted, now() as created, now() as updated,'UcoOmsBundle:SalesOrder' as entityName,'' as errMsg,
100 as priority,'' as subMark,'' as extraInfo  from SalesOrder s WHERE s.platformId = '100551' and s.created > '2022-05-10' and s.orderType = 'NORMAL' order by s.id desc limit 100;


## 更新库存

use uco;
alter user xxx identified by '你的密码';