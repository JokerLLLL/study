## 本地配置
```ini
xdebug.remote_enable = on
xdebug.profiler_enable = on
xdebug.profiler_enable_trigger = On
xdebug.profiler_output_name = cachegrind.out.%t.%p
xdebug.profiler_output_dir ="d:/wamp64/tmp"
xdebug.show_local_vars=0

xdebug.remote_handler = dbgp
xdebug.remote_host= 127.0.0.1
xdebug.remote_port = 9002
xdebug.idekey = PHPSTORM
```

2.添加解释器 设置->php cli
3.debug  端口 地址和 dbgp 和 xdebug 一致
4.server -> 127.0.0.1  80
5.请求里加 cookie XDEBUG_SESSION=PHPSTORM

打开监听 可以调试了


## vagrant 配合 phpstorm

https://my.oschina.net/findbill/blog/480971

xdebug.remote_host= 10.0.2.2 
dbgp 也填相同的ip地址。

该ip地址 由 netstat -r 得到 是vagrant 提供的网关。
server  添加远程域名 然后添加本地 对远程的映射。



