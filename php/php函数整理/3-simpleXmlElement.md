1.基本操作 

```
$new = new SimpleXmlElement('<test></test>');

$groups = $new ->groups;

$group1 = $groups->addChild('group');
$group->a = 'aa';
$group2 = $groups->addChild('group');
$group3 = $groups->addChild('group');

$groups->group->count() == 3; 

foreach($groups->group as $group) {
    var_dump(array $group); // ['a'=>'a']; []; []
}
```


```
 $requestResult = (array) $responseXml->ERROR;
 // 获取attribute属性值
 isset($requestResult['@attributes']['code'] 
```