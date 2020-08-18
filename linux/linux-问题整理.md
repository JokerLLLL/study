 
 ### docker数据连不上
 
 docker Waiting for database to come up...
 Timed out waiting for database to come-up
        
 原因：
 
1. 本地代码映射到docker里面，发现权限不对，所以虚拟机里的权限要更改
2. 虚拟机的网卡 适合用nat 和 侨联。 侨联网卡被windows的防火墙给禁用了

### 电子面单 顺丰 中通等 请求到响应需要十几秒

调查: 公司dns服务器解析有问题。