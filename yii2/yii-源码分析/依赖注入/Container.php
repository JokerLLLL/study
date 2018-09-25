<?php

/** 依赖容器 IoC 控制反转容器
 * Class Container
 */

//
class Container
{
     private $_definitions;

//    /** 设置控制容器
//     * @param $class
//     * @param $definition
//     */
//     public function set($class,$definition)
//     {
//        $this->_definitions[$class] = $definition;
//     }
//
//     public function get($class,$params = [])
//     {
//         $definition = $this->_definitions[$class];
//
//         if(isset($this->_definitions[$class]) && is_callable($this->_definitions[$class],true)) {
//             return call_user_func($definition,$this,$params);
//         }
//         throw new \Exception('call_back not found');
//     }


     public function get($class,$params = [])
     {
         return $this->build($class,$params);
     }

    /** 依赖 php反射 注入
     * @param $class
     * @param $params
     * @return object
     */
     public function build($class,$params)
     {
         $dependencies = [];
         $reflection = new ReflectionClass($class);
         $constructor = $reflection->getConstructor();
         if($constructor !== null ) {
//             $constructors = $constructor->getParameters();
//             var_dump($constructors[0]->getClass());die;
             foreach ($constructor->getParameters() as $property) {
//                 var_dump($constructor->getParameters());die;
                 $c = $property->getClass();
//                 var_dump($c);die;
                 if($c !== null) {
                     $dependencies[] = $this->get($c->getName());  //递归调用
                 }
             }
         }

         foreach ($params as $index=>$value) {
             $dependencies[$index] = $value;
         }
//         if($class === 'SendEmailByQQ') {
//             var_dump($dependencies);
//             var_dump($reflection->newInstanceArgs($dependencies));die;
//         }
         return $reflection->newInstanceArgs($dependencies);
     }
}