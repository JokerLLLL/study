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
UPDATE PrepackPlatform Left JOIN Product ON Product.id = PrepackPlatform.productId SET isEnable = 0 WHERE  Product.productCode in ('');


## mysql实现乐观锁

https://www.cnblogs.com/richerdyoung/p/6427668.html


## 查卡主的sql
show full processlist