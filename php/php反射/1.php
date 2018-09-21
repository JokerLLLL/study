<?php
class Person{
    private $name;
    public function __set($name, $value)
    {
        $setter = 'set' . $name;
        if (method_exists($this, $setter)) {
            $this->$setter($value);
        } elseif (method_exists($this, 'get' . $name)) {
            throw new Exception('Setting read-only property: ' . get_class($this) . '::' . $name);
        } else {
            throw new Exception('Setting unknown property: ' . get_class($this) . '::' . $name);
        }
    }

    public function __get($name)
    {
        $getter = 'get' . $name;
        if (method_exists($this, $getter)) {
            return $this->$getter();
        } elseif (method_exists($this, 'set' . $name)) {
            throw new Exception('Getting write-only property: ' . get_class($this) . '::' . $name);
        } else {
            throw new Exception('Getting unknown property: ' . get_class($this) . '::' . $name);
        }
    }

    public function setName($value)
    {
        $this->name  = $value;
        return true;
    }

    public function getName()
    {
        return $this->name;
    }
}
$student = new Person();


/**
 * 对象的反射
 */
$reflect = new ReflectionObject($student);
//获取属性
$props = $reflect->getProperties();
foreach ($props as $prop) {
    echo  $prop->getName() ."\n";
}
// 获取对象方法列表
$m = $reflect->getMethods();
foreach ($m as $prop) {
    echo $prop->getName() ."\n";
}
get_object_vars($student); //获取对象属性
get_class($student);       //类名
get_called_class();        //对象中获取类名
// 类属性
get_class_vars('Person');
// 返回由类的方法名组成的数组
get_class_methods('Person');


/**
 * 还原一个类
 */

$obj = new ReflectionClass('Person');
$className = $obj->getName();
$Methods = $Properties = array();
foreach($obj->getProperties() as $v)
{
    $Properties[$v->getName()] = $v;
}
foreach($obj->getMethods() as $v)
 {
     $Methods[$v->getName()] = $v;
}
echo "class {$className}\n{\n";
is_array($Properties)&&ksort($Properties);
foreach($Properties as $k => $v)
{
       echo "\t";
       echo $v->isPublic() ? ' public' : '',$v->isPrivate() ? ' private' : '',
       $v->isProtected() ? ' protected' : '',
       $v->isStatic() ? ' static' : '';
       echo "\t{$k}\n";
}
echo "\n";
if(is_array($Methods)) ksort($Methods);
foreach($Methods as $k => $v)
{
     echo "\tfunction {$k}(){}\n";
}
echo "}\n";

