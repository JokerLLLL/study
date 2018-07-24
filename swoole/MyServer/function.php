<?php

/** json格式请求
 * @param $url
 * @param null $data
 * @return mixed
 */
function HttpsRequest($url,$data = null){
    $headers = [
        "Content-type: application/json;charset='utf-8'",
        "Accept: application/json",
        "Cache-Control: no-cache",
        "Pragma: no-cache",
    ];


    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

    }

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}


/** 判读是否为合法json
 * @param $string
 * @return bool
 */
function is_json($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}
