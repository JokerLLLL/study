<?php
/**
 * Created by PhpStorm.
 * User: jokerl
 * Date: 2018/7/23
 * Time: 20:37
 */
require_once('config.php');
require_once('function.php');
require_once('DataHandle.php');

class Run
{
    /** 数据收到处理
     * @param $serv
     * @param $fd
     * @param $workerId
     * @param $data
     */
    public function runReceive($serv, $fd, $workerId, $data)
    {
        $handle = new DataHandle;
        $data = $handle->SetToHexString($data);
        //$data 数据处理
        if(!is_json($data)) {
            //水表硬件消息
            if($data_array = $handle->handle($data)) {
                echo '类型:'.$data_array['type'].'---地址:'.$data_array['addres'].PHP_EOL;
                switch ($data_array['type']) {
                    case "0000":       //注册
                        $this->register($serv,$fd,$data_array);
                        break;
                    case "0001":       //登陆
                        $this->login($serv,$fd,$data_array);
                        break;
                    case "0002":       //心跳
                        $this->liveheart($serv,$fd,$data_array);
                        break;
                    case "0003":       //退出
                        $this->loginout($serv,$fd,$data_array);
                        break;
                    case "1000":       //数据上报
                        $this->getBaseData($serv,$fd,$data_array);
                        break;
                    default:
                        echo '收到未知的数据：'.$data.PHP_EOL;
                        break;
                }
            }

        }else{
            //服务器客户端消息
            echo '收到json数据：'.PHP_EOL;

        }
        echo date('YmdHis').'处理完成'.PHP_EOL;
    }

    /** 进程关闭处理
     * @param $serv
     * @param $fd
     * @param $workerId
     */
    public function runClose($serv, $fd, $workerId)
    {

    }


    public function register($serv, $fd, $data)
    {
        $res_data =  HttpsRequest(API_SERVER . '/machine/machine-api/create', json_encode($data));
        echo  "接口回执 :".$res_data.PHP_EOL;

        if (!empty($res_data) )
        {
            $res_data = json_decode($res_data,true);
            if (!empty($res_data) && ($res_data['errcode'] == 0))
            {
                $data_json = [
                    "auth_key"=>$res_data['data']['auth_key'],
                ];
                $data['data_json'] = json_encode($data_json);
            }
        }

        $this->sendBack($serv, $fd, $data,'8001');
        return true;
    }

    public function login($serv, $fd, $json)
    {

    }

    public function liveheart($serv, $fd, $json)
    {

    }

    public function loginout($serv,$fd,$json)
    {

    }

    public function getBaseData($serv, $fd ,$json)
    {

    }


    /** 数据回执
     * @param $serv
     * @param $fd
     * @param $data
     * @param string $sign
     * @return bool
     */
    public function sendBack($serv,$fd,$data,$sign="8001")
    {
        $handle = new DataHandle;

        $str_time = dechex(time());
        $cmd_len10 = 0;
        if (!empty($data['data_json']))
        {
            $data_jsonstr16 = $handle->SetToHexString($data['data_json']);
            $cmd_len10 = strlen($data_jsonstr16);
        }


        $datalen = substr('0000'.dechex($cmd_len10), -4);
        $data_crc = $data['addres'].$data['type'].$str_time.$sign.$datalen.$data_jsonstr16;
        $data_jiexi = $handle->UnsetFromHexString($data_crc);
        $check_now = $handle->crc16($data_jiexi);
        $cmd_all = $data['start'].$data_crc .$check_now;

        echo "回执数据:".$cmd_all.PHP_EOL;

        $serv->send($fd,$cmd_all);

        //纪录fd
        $mem = new Memcache;
        $mem->connect("127.0.0.1", 11211);
        $all_cmd_arr = $mem->get('all_cmd_arr');
        $all_cmd_arr[$data['addres']] = $fd;
        echo "Client set ids:".json_encode($all_cmd_arr).PHP_EOL;

        $mem->set('all_cmd_arr', $all_cmd_arr, 0, 1000);
        $mem->set('all_cmd_arr_json', json_encode($all_cmd_arr), 0, 1000);
        return true;
    }
}