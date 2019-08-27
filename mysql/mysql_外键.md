### 外键
SET FOREIGN_KEY_CHECKS=0; -- 挂起外键约束
TRUNCATE TABLE  manualsalesorder; -- 清空表
SET FOREIGN_KEY_CHECKS=1; -- 释放挂起

###  查询外键

select * from INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
where CONSTRAINT_SCHEMA = "oms_kiki" -- 表面
and  referenced_table_name = "manualsalesorder"; -- 查看外键约束（被约束的字表）

https://blog.csdn.net/linjingke32/article/details/89761328