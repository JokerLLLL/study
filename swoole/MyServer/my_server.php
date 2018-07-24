<?php
/**
 * Created by PhpStorm.
 * User: jokerl
 * Date: 2018/7/23
 * Time: 18:02
 */

class Server
{
    private $_serv;
    private $_run;

    public function __construct($ip = '0.0.0.0', $port = 9505)
    {
        $this->_serv = new swoole_server($ip, $port);
        $this->_serv->set([
            'max_conn' => 20000,	//此参数用来设置Server最大允许维持多少个tcp连接。
            'worker_num' => 5,
            'open_tcp_keepalive' => 1,
            'daemonize' => false,//启动进程守护
            //'log_file' => __DIR__ . '/log/server.log',//输出从定向
            'heartbeat_check_interval' => 60,
            'heartbeat_idle_time' => 600,
        ]);
        $this->_serv->on('Connect', [$this, 'onConnect']);
        $this->_serv->on('WorkerStart', [$this, 'onWorkerStart']);
        $this->_serv->on('Receive', [$this, 'onReceive']);
        $this->_serv->on('Close', [$this, 'onClose']);

        // table 全局变量
        // $table = new swoole_table(1024);
        // $table->column('fd', swoole_table::TYPE_INT);
        // $table->column('from_id', swoole_table::TYPE_INT);
        // $table->column('d_id', swoole_table::TYPE_STRING, 64);
        // $table->create();
        // $this ->_serv->table = $table;

    }

    //加载回调执行
    public function onWorkerStart($serv, $workerId)
    {
        require_once('Run.php');
        $this->_run = new Run;
    }

    public function onConnect($serv, $fd, $workerId)
    {
        echo date('YmdHis') . '进程开启' . $fd . PHP_EOL;
    }


    public function onReceive($serv, $fd, $workerId, $data)
    {
        $this->_run->runReceive($serv, $fd, $workerId, $data);
    }


    public function onClose($serv, $fd, $workerId)
    {
        $this->_run->runClose($serv, $fd, $workerId);
        echo date('YmdHis') . '进程关闭' . $fd . PHP_EOL;
    }


    public function start()
    {
        $this->_serv->start();
    }


}

$server = new Server;

$server->start();