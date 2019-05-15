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