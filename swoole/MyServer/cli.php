<?php
/**
 * Created by PhpStorm.
 * User: jokerl
 * Date: 2018/7/24
 * Time: 11:31
 */

class MaClient {
    private $_cli;
    public function __construct(){
        $this ->_cli = new swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);
        $this ->_cli->on('Connect',[$this,'onConnect']);
        $this ->_cli->on('Receive',[$this,'onReceive']);
        $this ->_cli->on('Error',[$this,'onError']);
        $this ->_cli->on('Close',[$this,'onClose']);
    }
    public function onConnect($cli){
        // 注册
        $cli ->send('7e7e0000303900005b42d458000100307b22736e223a20223132333435363738222c227265675f6b6579223a202231323334353637383930206162636465227d2d4f');
        //32秒心跳包
        swoole_timer_tick(32000,function() use ($cli){
            $cli->send("7e7e0000303900025b40264500010000ffbd");
        });
    }
    //事件回调
    public function onReceive($cli,$data) {
        echo $data."\n";
        $cli->send('');
    }

    public function onError($cli){
        echo 'error:'.$cli->errCode."\n";
    }

    public function onClose($cli){
        echo 'client is closed';
    }

    public function connect($ip="114.55.107.93",$port=9505){
        $this ->_cli->connect($ip,$port);
    }


}

$client = new MaClient;

$client ->connect();
