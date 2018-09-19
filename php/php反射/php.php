<?php
class Person{
    private $name;

    public function __set($name, $value)
    {
        $setter = 'set' . $name;
        if (method_exists($this, $setter)) {
            $this->$setter($value);
        } elseif (method_exists($this, 'get' . $name)) {
            throw new InvalidCallException('Setting read-only property: ' . get_class($this) . '::' . $name);
        } else {
            throw new UnknownPropertyException('Setting unknown property: ' . get_class($this) . '::' . $name);
        }
    }

    public function __get($name)
    {
        $getter = 'get' . $name;
        if (method_exists($this, $getter)) {
            return $this->$getter();
        } elseif (method_exists($this, 'set' . $name)) {
            throw new InvalidCallException('Getting write-only property: ' . get_class($this) . '::' . $name);
        } else {
            throw new UnknownPropertyException('Getting unknown property: ' . get_class($this) . '::' . $name);
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
//$student->name = 'Tom';
$student ->setName('dd');
//var_dump($student->name);die;


$reflect = new ReflectionObject($student);
$props = $reflect->getProperties();
//var_dump($props);die;
foreach ($props as $prop) {
    print $prop->getName() ."\n";
}
// 获取对象方法列表
$m = $reflect->getMethods();
foreach ($m as $prop) {
    print $prop->getName() ."\n";
}

var_dump(get_object_vars($student));
// 类属性
var_dump(get_class_vars(get_class($student)));
// 返回由类的方法名组成的数组
var_dump(get_class_methods(get_class($student)));

echo get_class($student);





$obj = new ReflectionClass('person');
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

