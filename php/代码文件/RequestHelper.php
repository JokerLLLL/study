<?php
/**
 * Created by PhpStorm.
 * User: jokerl
 * Date: 2018/10/26
 * Time: 10:59
 */

namespace backend\components;


class RequestService
{

    CONST TYPE_POST = 'POST';
    CONST TYPE_GET = 'GET';
    CONST HEADER_JSON = 'Content-Type: application/json; charset=utf-8';


    /** 连接访问
     * @param $url
     * @param string $type
     * @param array $arr
     * @param array $headers
     * @return bool|mixed
     */
    public static function httpCurl($url, $arr = [], $type = self::TYPE_POST, $headers = [self::HEADER_JSON])
    {
        //get 请求附带参数
        if($type == self::TYPE_GET && $arr) {
            $url .= '?'.http_build_query($arr);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);      //设置超时时间 30s
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //设置参数 成功返回内容 失败返回false
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        if(!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        if ($type == self::TYPE_POST) {
            if(in_array(self::HEADER_JSON,$headers)) {
                $arr = json_encode($arr);
            }
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);//post数据 json或array
        }
        $output = curl_exec($ch);
        if (curl_errno($ch)) {
            return false;
        }
        curl_close($ch);
        return $output;
    }


    /** ssl 加密请求
     * @param $url
     * @param $request_data
     * @param $cert_path
     * @param $key_path
     * @return bool|mixed
     */
    public static function sslCurl($url, $request_data, $cert_path, $key_path)
    {
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_TIMEOUT, 30);

        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
        //默认格式为PEM，可以注释
        curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLCERT,$cert_path);
        //默认格式为PEM，可以注释
        curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');
        curl_setopt($ch,CURLOPT_SSLKEY,$key_path);

        curl_setopt($ch,CURLOPT_HEADER,FALSE);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,TRUE);
        curl_setopt($ch,CURLOPT_POST, true);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $request_data);
        $output = curl_exec($ch);
        if (curl_errno($ch)) {
            return false;
        }
        curl_close($ch);
        return $output;
    }


    /** arrayToXml
     * @param $arr
     * @return string
     */
    public static  function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key=>$val)
        {
            $xml.="<".$key.">".$val."</".$key.">";
        }
        $xml.="</xml>";
        return $xml;
    }

    public static function arrayToXmlLast(array $ar, $root = self::XML_ROOT, $rootAttrs = [])
    {
        $xml = new \SimpleXMLElement(self::XML_HEAD.'<'.$root.'>'.'</'.$root.'>');
        foreach ($rootAttrs as $key => $value) {
            $xml->addAttribute($key, $value);
        }
        self::RecursiveXML($xml, $ar);
        return $xml->asXML();
    }

    private static function RecursiveXML(\SimpleXMLElement $xml, array $element)
    {
        foreach ($element as $k => $v) {
            if (is_array($v)) {
                $ch = $xml->addChild($k);
                self::RecursiveXML($ch, $v);
            } else {
                $xml->addChild($k, str_replace("&", "&amp;", $v));
            }
        }
    }

    /** xmlToArray
     * @param $xml
     * @return mixed
     */
    public static  function xmlToArray($xml) {
        $arr = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $arr;
    }


    /** 请求参数拼接
     * @param $request_data
     * @return string
     */
    public static function serializeData($request_data)
    {
        ksort($request_data);
        return http_build_query($request_data);
    }


}