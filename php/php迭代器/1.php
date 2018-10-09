<?php

//普通对象的遍历
class Myclass{

    public $a = 'php';

    public $b = 'onethink';

    public $c = 'thinkphp';

    public $f = 'other';

    protected $e = 'protected';

    private $d = 'private';

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

}

$myclass = new Myclass();

//用foreach()将对象的属性循环出来  //只能是公共属性
foreach($myclass as $key=>$val){

    echo '$'.$key.' = '.$val."\n";

}

/*返回
    $a = php
    $b = onethink
    $c = thinkphp
*/

/*class Number implements Iterator
{

    protected $key;
    protected $val;
    protected $count;

    public function __construct(int $count){
       $this->count = $count;
    }

    public function rewind()
    {
       $this->key = 0;
        $this->val = 0;
    }

    public function next()
    {
        $this->key += 1;
        $this->val += 2;
    }

    public function current()
    {
        return $this->val;
    }

    public function key()
    {
        return $this->key + 1;
    }

    public function valid()
    {
        return $this->key < $this->count;
    }
}

foreach (new Number(5) as $key => $value)
{
    echo microtime(true);
    echo "{$key} - {$value}\n";
}*/

/** 迭代器
 * Class Number
 */
class Number implements Iterator{
    protected $i = 1;
    protected $key;
    protected $val;
    protected $count;
    public function __construct(int $count){
        $this->count = $count;
        echo "第{$this->i}步:对象初始化.\n";
        $this->i++;
    }
    public function rewind(){
        $this->key = 0;
        $this->val = 0;
        echo "第{$this->i}步:rewind()被调用.\n";
        $this->i++;
    }
    public function next(){
        $this->key += 1;
        $this->val += 2;
        echo "第{$this->i}步:next()被调用.\n";
        $this->i++;
    }
    public function current(){
        echo "第{$this->i}步:current()被调用.\n";
        $this->i++;
        return $this->val;
    }
    public function key(){
        echo "第{$this->i}步:key()被调用.\n";
        $this->i++;
        return $this->key;
    }
    public function valid(){
        echo "第{$this->i}步:valid()被调用.\n";
        $this->i++;
        return $this->key < $this->count;
    }
}

    $number = new Number(5);
echo "start...\n";
foreach ($number as $key => $value){
    echo "{$key} - {$value}\n";
}
echo "...end...\n";





