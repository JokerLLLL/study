#  EXPLAIN 输出格式
id: SELECT 查询的标识符. 每个 SELECT 都会自动分配一个唯一的标识符.
select_type: SELECT 查询的类型.
table: 查询的是哪个表
partitions: 匹配的分区
type: join 类型
possible_keys: 此次查询中可能选用的索引
key: 此次查询中确切使用到的索引.
ref: 哪个字段或常数与 key 一起被使用
rows: 显示此查询一共扫描了多少行. 这个是一个估计值.
filtered: 表示此查询条件所过滤的数据的百分比 
extra: 额外的信息

# type类型 判断 全表扫描 还是 索引扫描 等.

const system  一条数据 唯一索引或主键查询
 
eq_ref        多出现 join 查询效率高

ref           多表join

rang          多出现咋 范围 查询 in < > 等

index         全索引扫描

all           全表扫描