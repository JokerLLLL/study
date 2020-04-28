### 迁移数据
## 方案1：

1. 针对历史未处理的数据进行确保处理完成。
2. rename table to _bak // 历史数据打包
3. doctrine schema create table // 生成对应的表单
4. 针对_bak 进行历史归档 // 按年份归档 并最后删除_bak

```sql
CREATE TABLE address_2018 like address;
INSERT INTO address_2018(
`country`,
`province`,
`city`,
`district`,
`address`,
`postalCode`,
`recipientName`,
`recipientPhone`,
`recipientEmail`,
`isDefault`,
`platformId`,
`platformAddressId`,
`created`,
`updated`,
`customerId`,
`phone`,
`recipientRealName`,
`recipientIDCard`,
`isDeleted` 
) SELECT
`country`,
`province`,
`city`,
`district`,
`address`,
`postalCode`,
`recipientName`,
`recipientPhone`,
`recipientEmail`,
`isDefault`,
`platformId`,
`platformAddressId`,
`created`,
`updated`,
`customerId`,
`phone`,
`recipientRealName`,
`recipientIDCard`,
`isDeleted` 
FROM
	address 
WHERE
	created >= '2018-01-01' 
	AND created <= '2019-01-01';
``` 

## 切片
```sql
-- 会忽略 主键 变成 default 0
CREATE TABLE address_test01(select * from address where created > '2019-01-01 00:00:00');

-- 会保留主键 （采用）
CREATE TABLE address_test02 like address;
INSERT INTO address_test02 select * from address where created > '2019-01-01 00:00:00';
```
## 重命名
ALTER TABLE address_2020 RENAME address_22224;
rename table address_22224 to address_33333;

## 搬运shunfengIncoming

```sql
-- rename备份

rename table `ShunfengIncoming` to ShunfengIncoming_bak;

-- 上线issue 新建表 不含有errorMsg

CREATE TABLE `ShunfengIncoming` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `entityId` varchar(255) NOT NULL,
  `method` varchar(100) NOT NULL,
  `requestID` varchar(40) NOT NULL,
  `serviceCode` varchar(50) NOT NULL,
  `msgData` longtext NOT NULL,
  `isProcessed` tinyint(1) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime NOT NULL,
  `isDeleted` tinyint(1) NOT NULL,
  `warehouse` int(11) DEFAULT NULL,
  `tryTimes` smallint(6) NOT NULL,
  `nextTriggerAt` datetime DEFAULT NULL,
  `errMsg` longtext NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniRequestID` (`requestID`),
  KEY `isProcessedMethodIndex` (`isProcessed`,`warehouse`,`method`),
  KEY `entityIdIndex` (`entityId`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


-- 搬运未出的incoming 到 新表  (说明：isProcessed 是两张表都含有的所以必须加上表名否则数据全部搬运！！！！）


INSERT INTO `ShunfengIncoming` (
`id`,
`entityId`,
`method`,
`requestID`,
`serviceCode`,
`msgData`,
`isProcessed`,
`created`,
`updated`,
`isDeleted`,
`warehouse`,
`tryTimes`,
`nextTriggerAt`,
`errMsg`,

) SELECT
`id`,
`entityId`,
`method`,
`requestID`,
`serviceCode`,
`msgData`,
`isProcessed`,
`created`,
`updated`,
`isDeleted`,
`warehouse`,
`tryTimes`,
`nextTriggerAt`,
`errMsg` 
FROM
	ShunfengIncoming_bak 
WHERE
	ShunfengIncoming_bak.isProcessed = 0;

-- 上线系统

```