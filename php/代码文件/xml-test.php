<?php

function arrayToXmlLast(array $ar, $root = 'xml', $rootAttrs = [])
{
    $xml = new \SimpleXMLElement('<'.$root.'>'.'</'.$root.'>');
    foreach ($rootAttrs as $key => $value) {
        $xml->addAttribute($key, $value);
    }
    RecursiveXML($xml, $ar);
    return $xml->asXML();
}

function RecursiveXML(\SimpleXMLElement $xml, array $element)
{
    foreach ($element as $k => $v) {
        if (is_array($v)) {
            $ch = $xml->addChild($k);
            RecursiveXML($ch, $v);
        } else {
            $xml->addChild($k, str_replace("&", "&amp;", $v));
        }
    }
}


$xml = new \SimpleXMLElement('<items><item>www</item><item>xxxx</item></items>');
$r1 = $xml->asXml();


$a = [
    'items'=>[
        'wwww',
        'xxxx'
    ],
];
var_dump(arrayToXmlLast($a));
$xml2 = new \SimpleXMLElement('<xml></xml>');
$items = $xml2->addChild('items');
$items->addChild('item','xx');
$items->addChild('item','yy');
$items->addChild('item','zzz');
function xmlToArray($xml) {
    $arr = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    return $arr;
}




var_dump($xml2->asXml());
var_dump(xmlToArray($xml2->asXml()));
var_dump(arrayToXmlLast(xmlToArray($xml2->asXml())));

#############  SimpleXmlElement 说明


$xml = new SimpleXmlElement('
<xml>
	<OrderAddedServices>
		<OrderAddedService>
			<ServiceCode>CARD</ServiceCode>
			<Attr03>卡片内容</Attr03>
		</OrderAddedService>
		<OrderAddedService>
			<ServiceCode>GIFTPK</ServiceCode>
			<Attr03>需要礼盒</Attr03>
		</OrderAddedService>
		<OrderAddedService>
			<ServiceCode value1="test1" value2="test2">TRIAL</ServiceCode>
		</OrderAddedService>
	</OrderAddedServices>
	<OrderAddedServices>
		<next></next>
	</OrderAddedServices>
</xml>');


var_dump($xml->OrderAddedServices->OrderAddedService);  // 等于 $xml->OrderAddedServices->OrderAddedService[0]
var_dump($xml->OrderAddedServices->OrderAddedService[1]);


foreach ($xml->OrderAddedServices->OrderAddedService as $os) {  // 循环 OrderAddedService 节点。
    var_dump($os);
}

// 子节点如果只有一个名字
$xml->OrderAddedServices->children() === $xml->OrderAddedServices->OrderAddedService;

// 添加子节点

$xml->addChild('info');

//添加属性
$xml->addAttribute('value1', 'xxxxx1');

// 获取属性
$testAttributes = (array)$xml->OrderAddedServices->OrderAddedService[2]->ServiceCode->attributes();

/**
 * array(1) {
 * ["@attributes"]=>
 * array(2) {
 * ["value1"]=>
 * string(5) "test1"
 * ["value2"]=>
 * string(5) "test2"
 * }
 * }
 */
var_dump($testAttributes);

$xml_array = (array)$xml;
var_dump($xml_array); // $xml_array['@attributes']['value1'] 获取到属性

// 获取数量
echo $xml->OrderAddedServices->OrderAddedService->count();