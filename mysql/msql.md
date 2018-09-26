//wamp msql设置：
01.打开 Mysql控制台
02.查看 general_log 状态：SHOW VARIABLES LIKE '%general_log%';确认 log记录档在何处。
03.打开 general_log 监看：SET GLOBAL general_log = 'ON';执行网站 ，看 log记录档，执行了那些SQL语句。
04.关闭 general_log 取消监看:SET GLOBAL general_log = 'OFF';


//设备批量查询日志里的  最新或最旧的消息 

$sql = "SELECT * from band_step where id in (SELECT  max(id) from band_step where MID in (\"{$deviceList2}\") GROUP BY MID)";  //max 时间可能重复 in id解决 不然子查询和外查询都要加 in deviceList条件 还要group by


//时间格式换  

DATE_FORMAT(date,format)  时间戳转字符串
UNIX_TIMESTAMP(create_time)  字符串转时间戳

format格式：http://www.w3school.com.cn/sql/func_date_format.asp
select uid,userid,username,email,FROM_UNIXTIME(addtime,'%Y年%m月%d') from members;
SELECT *,FROM_UNIXTIME(UNIX_TIMESTAMP(create_time),'%Y-%m-%d %H') as atime FROM `machine_room_log`;


//字段裁切

MySQL 字符串截取函数：left(), right(), substring(), substring_index()。

select left(create_time,13) as atime form member; 

//时间比较 (本质进行了补充00:00:00操作)
SELECT * FROM `machine_room_log` where create_time<'2018-07-30';
小于不包含2018-07-30
SELECT * FROM `machine_room_log` where create_time>'2018-07-30';
大于包含2018-07-30 


//mysql 的事务锁
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




