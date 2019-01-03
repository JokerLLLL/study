                    <?php
/**
 * Created by PhpStorm.
 * User: jokerl
 * Date: 2018/8/29
 * Time: 21:08
 */

/**
 * php可变参数列表
 */
function more_args() {
    $args = func_get_args();          //将所有传递给脚本函数的参数当做一个数组返回
    for($i=0; $i<count($args); $i++) {               //使用for循环遍历数组$args
        echo "第".$i."个参数是".$args[$i]."<br>";    //分别输出传入函数的每个参数
    }
}
function more_args2() {
    for($i=0; $i<func_num_args(); $i++) {            //使用for循环遍历数组$args
        echo "第".$i."个参数是".func_get_arg($i)."<br>";//分别输出传入函数的每个参数
    }
}
/* php7 */
function more_args3(...$params){
    var_dump($params);
}
more_args("one", "two", "three", 1, 2, 3);           //调用函数并输入多个参数


/** 两个日期 日期列表
 * @param $start
 * @param $end
 */
function prDates($start,$end){
    $dt_start = strtotime($start);
    $dt_end = strtotime($end);
    while ($dt_start<=$dt_end){
        echo date('Y-m-d',$dt_start)."\n";
        $dt_start = strtotime('+1 day',$dt_start);
    }
}
prDates('2018-02-31','2018-03-05');


/** 连接访问
 * @param $url
 * @param string $type
 * @param array $arr
 * @param array $headers
 * @return bool|mixed
 */
function httpCurl($url, $type = 'get', $arr = [],$headers = [])
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);      //设置超时时间 30s
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


/**
 * 将xml转为array
 * @param  string 	$xml xml字符串或者xml文件名
 * @param  bool 	$isfile 传入的是否是xml文件名
 * @return array    转换得到的数组
 */
function xmlToArray($xml,$isfile=false)
{
    //禁止引用外部xml实体
    libxml_disable_entity_loader(true);
    if ($isfile) {
        if (!file_exists($xml)) return false;
        $xmlstr = file_get_contents($xml);
    } else {
        $xmlstr = $xml;
    }
    $result = json_decode(json_encode(simplexml_load_string($xmlstr, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    return $result;
}


/** 随机 最小值和最大值 之间的数
 * @param int $min
 * @param int $max
 * @return int
 */
function randFloat($min=0, $max=1){
    return round($min + mt_rand()/mt_getrandmax() * ($max-$min),2);
}


/** yii2 后台url创建 + $_GET 数组
 * 将 index?id=1 变成 ['index',['id'=>1,'get_params'=>'value']]
 * @param $url
 * @return int
 */
function buildUrl($url)
{
    $url_array = explode('?',$url);
    $str_url = array_shift($url_array);

    $before_params = [];
    foreach ($url_array as $value) {
        $params = explode('=',$value);
        $before_params[$params[0]] = $params[1];
    }
    $new_array = $before_params+$_GET;
    array_unshift($new_array,$str_url);
    return $new_array;
}

/**
 * @param $num         科学计数法字符串  如 2.1E-5
 * @param int $double 小数点保留位数 默认5位
 * @return string
 */

function sctonum($num, $double = 5){
    if(false !== stripos($num, "e")){
        $a = explode("e",strtolower($num));
        return bcmul($a[0], bcpow(10, $a[1], $double), $double);
    }
}

echo sctonum(2.1E-5, 6); //输出0.000021

/** 过滤表情
 * @param $str
 * @return mixed
 */
function filterEmoji($str)
{
    $str = preg_replace_callback(
        '/./u',
        function (array $match) {
            return strlen($match[0]) >= 4 ? '[emoji]' : $match[0];
        },
        $str);
    return $str;
}

