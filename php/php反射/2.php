<?php
/**
 * Created by PhpStorm.
 * User: jokerl
 * Date: 2018/9/25
 * Time: 20:28
 */

/**  依赖反射进行 类的实例化
 * @param $class
 * @param $params
 * @return object
 */
function build($class,$params=[])
{
    $dependencies = [];
    $reflection = new ReflectionClass($class);
    $constructor = $reflection->getConstructor();
    if($constructor !== null ) {
//             $constructors = $constructor->getParameters();   //这个类的构造函数参数
//             var_dump($constructors[0]->getClass());die;
        foreach ($constructor->getParameters() as $property) {
            $c = $property->getClass();
            if($c !== null) {
                $func = __FUNCTION__;
                $dependencies[] = $func($c->getName());  //递归调用
            }
        }
    }
    foreach ($params as $index=>$value) {
        $dependencies[$index] = $value;  // 产生的参数
    }

    return $reflection->newInstanceArgs($dependencies); //通过依赖 实例化
}

class A{
    public $b;
    public function __construct(B $b)
    {
        $this->b = $b;
    }
}

class B{
    public $c;
    public $d;
    public function __construct(C $c,D $d)
    {
        $this->c = $c;
        $this->d = $d;
    }
}

class C
{
    public $c_property;
    public function __construct($c_property = 'ccc')
    {
        $this->c_property = $c_property;
    }
}

class D
{
    public $d_property;
    public function __construct($d_property = 'DDD')
    {
        $this->d_property = $d_property;
    }
}

var_dump(build('A'));

/*object(A)#12 (1) {
["b"]=>
  object(B)#7 (2) {
  ["c"]=>
    object(C)#13 (1) {
    ["c_property"]=>
      string(3) "ccc"
    }
    ["d"]=>
    object(D)#14 (1) {
    ["d_property"]=>
      string(3) "DDD"
    }
  }
}*/



