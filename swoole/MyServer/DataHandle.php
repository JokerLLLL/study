<?php
/**
 * Created by PhpStorm.
 * User: jokerl
 * Date: 2018/7/23
 * Time: 20:37
 */

class DataHandle
{
    public $return = [
        "start" => '',     //起始符 2  固定命令头   7e 7e
        "address" => '',  //终端地址 4
        'type' => '',   //帧类型 2  命令类型 0x0000 : 注册   0x0001:登陆       0x0002:心跳  0x0003:退出 0x1000 :数据上报  0x2000:控制下发  0x3000: 参数配置
        "time" => '',   //时间戳 4
        'sign' => '',    //标识符 2  00 01  上行CRC16  10 01 ： 下行CRC16   00 10 上行AES128   10 10 ： 下行AES128
        'length' => '',//消息长度 2
        'data' => '',   //消息体
        'check'=>'',     //校验码
       // "data_crc"=>'',     //校验数据
        //'check_now'=>'',     //校验码
        'data_json' => [],      //json 数据
    ];

    public function handle($data)
    {
        $len = strlen($data);
        $return['start'] =  substr($data,0,4);
        $return['addres'] = substr($data,4,8);
        $return['type'] =  substr($data,12,4);
        $return['time'] =  substr($data,16,8);
        $return['sign'] =  substr($data,24,4);
        $return['length'] = substr($data,28,4);
        $return['data'] = substr($data,32,$len-32-4);
        $return['check'] =  substr($data,-4);
        $return['data_json'] = json_decode($this->UnsetFromHexString($return['data']),true);
        if($this->check($data)) {
            return $return;
        }
        echo date('YmdHis:接收数据 ').$data;
        return false;
    }
    /** string转Hex   ||    真正的Hex 转成 16进制字符串
     * @param $str
     * @return bool|string
     */
    public function SetToHexString($str)
    {
        if(!$str)return false;
        $tmp="";
        for($i=0;$i<strlen($str);$i++)
        {
            $ord=ord($str[$i]);
            $tmp.=$this->SingleDecToHex(($ord-$ord%16)/16);
            $tmp.=$this->SingleDecToHex($ord%16);
        }
        return $tmp;
    }

    public function SingleDecToHex($dec)
    {
        $tmp="";
        $dec=$dec%16;
        if($dec<10)
            return $tmp.$dec;
        $arr=array("a","b","c","d","e","f");
        return $tmp.$arr[$dec-10];
    }

    /** Hex转string  ||     16进制转成 真正的Hex
     * @param $str
     * @return bool|string
     */
    public function UnsetFromHexString($str)
    {
        if(!$str)return false;
        $tmp="";
        for($i=0;$i<strlen($str);$i+=2)
        {
            $tmp.=chr($this->SingleHexToDec(substr($str,$i,1))*16+$this->SingleHexToDec(substr($str,$i+1,1)));
        }
        return $tmp;
    }

    public function SingleHexToDec($hex)
    {
        $v=ord($hex);
        if(47<$v&$v<58)
            return $v-48;
        if(96<$v&$v<103)
            return $v-87;

    }

    /** crc16 加密解密
     * @param $string
     * @return string
     */
    public function crc16($string)
    {
        $crc = 0xFFFF;
        for ($x = 0; $x < strlen ($string); $x++) {
            $crc = $crc ^ ord($string[$x]);
            for ($y = 0; $y < 8; $y++) {
                if (($crc & 0x0001) > 0) {
                    $crc = (($crc >> 1) ^ 0xA001);
                } else { $crc = $crc >> 1; }
            }
        }
        return dechex($crc);
    }

    /** 检查数据验证是否缺失
     * @param $string
     * @return bool
     */
    public function check($string)
    {
        //将数据去掉头尾 16进制转成可见字串 在进行src16加密
        $check_string = $this->UnsetFromHexString(substr($string,4,-4));
        $check_now = substr('0000'.$this->crc16($check_string), -4);
        $check_end = substr($string,-4);
        if($check_now === $check_end) {
            return true;
        }
        return false;
    }

}