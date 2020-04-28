### 查询到更新

https://www.cnblogs.com/deepalley/p/11018918.html

```sql
UPDATE user_online_month_atu a
INNER JOIN (
SELECT
user_id,
sum(c.online_times) as online_times,
SUM(c.login_count) as login_count,
Sum(c.view_page_count) as view_page_count,
LEFT(c.log_date,length(c.log_date) - 2) as date
FROM
user_online_time_atu c
GROUP BY
c.user_id ,date
) b ON a.user_id = b.user_id AND a.`month`=b.date
SET a.online_time = b.online_times ,a.login_count=b.login_count,a.view_page_count=b.view_page_count

```
说明： On2 的数据量 join代表会重复全表扫描 错误示例。

