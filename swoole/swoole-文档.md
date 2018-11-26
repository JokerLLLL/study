$port1 = $server->listen("127.0.0.1", 9501, SWOOLE_SOCK_TCP);
$port2 = $server->listen("127.0.0.1", 9502, SWOOLE_SOCK_UDP);
$port3 = $server->listen("127.0.0.1", 9503, SWOOLE_SOCK_TCP | SWOOLE_SSL);
多协议进行接听； 返回对象swoole_server_port；
$port 可调用set  on等函数；


# /* task进程里使用  协程 无法发送 $serv 信息  */


#   注册finish 异步进程结束的返回值来自task
在task 返回值不是NULL 才会触发 finish回调

# onReceive回调 意外要使用 协程 要使用 go(function(){}); 函数
/点型的 在 onWorkerStart onWorkerExit task中 要使用go

