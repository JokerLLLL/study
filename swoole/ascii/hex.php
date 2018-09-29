<?php


Class DateHandle{

    /** string转Hex
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

    /** Hex转string
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
    public function crc16($string) {
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


    /**  验证两位值 string是 要UnsetFromHexString 解析过的
     *   异或校验
     *
     */
    public function crcor($string) {
        $crc = 0x7E;
        for ($x = 0; $x < strlen ($string); $x++) {
            $crc = $crc ^ ord($string[$x]);
        }
        return dechex($crc);
    }


}


$handle = new DateHandle();

//将 "7e7e" 转换成 "\x7e\x7e"
var_dump($handle->UnsetFromHexString("7e7e"));  //接收到的数据

//将 "\x7E\x7E" 转变 "7e7e"

var_dump($handle->SetToHexString("\x7E\x7E"));


//封装字符串数据
$string = "{'json':3}"; //就是16进制的 \x7B\27 ...
$dec16 = $handle->SetToHexString($string);
//var_dump($dec16);  //7b276a736f6e273a337d 将16进制变成Ascii操作  然后才能计算长度

$num = strlen($dec16)/2; //几个字节  16进制  2位为1个字节
$length16 = substr('0000'.dechex($num), -4); //Ascii 16进制长度 16进制表示

$put = $handle->UnsetFromHexString($length16.$dec16); //传输的内容  解析回去 真正的16进制 然后发送

