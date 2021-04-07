##  grep 用法

-v 或 --revert-match : 显示不包含匹配文本的所有行。

grep 'content' file_name



## cat | grep  > 同个文件
cat error_id.log |grep  'entityName:ManualSalesOrder' > error_id.log


数据直接丢失！！！！！！


## 统计数据
// egrep 正则 -o 匹配需要的
// uniq 配合sort进行处理统计处理
cat  pii-migration_SalesOrder.app20a2-oms-elc.log-20210327   | egrep -o 'Duration\: [0-9\:]+' | sort |uniq  -c | sort -n

