<?php
/**
 * Created by PhpStorm.
 * User: jokerl
 * Date: 2018/10/26
 * Time: 10:59
 */

namespace backend\components;


class RequestHelper
{

    /** 连接访问
     * @param $url
     * @param string $type
     * @param array $arr
     * @param array $headers
     * @return bool|mixed
     */
    public static function httpCurl($url, $type = 'get', $arr = [],$headers = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);      //设置超时时间 30s
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //设置参数 成功返回内容 失败返回false
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        //json头
        $headers[] = 'Content-Type: application/json; charset=utf-8';
        if(!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        if ($type == 'post') {
            $json = json_encode($arr);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $json);//post数据 json或array
        }
        $output = curl_exec($ch);
        if (curl_errno($ch)) {
            return false;
        }
        curl_close($ch);
        return $output;
    }


}