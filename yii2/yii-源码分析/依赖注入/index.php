<?php
/**
 * Created by PhpStorm.
 * User: jokerl
 * Date: 2018/9/25
 * Time: 11:39
 */

require_once 'Container.php';
require_once 'SendEmail.php';
require_once 'SendEmailByQQ.php';
require_once 'SendEmailBy163.php';

class User {
    public  $_sendObj;

    public function __construct(SendEmailByQQ $obj,$a =5,$v=55)
    {
        $this->_sendObj = $obj;
    }
    public function register()
    {
        $this->_sendObj->send();
    }
}


/** 通过注入  解决依赖关系
 *
 *

class User {
    public  $_sendObj;

    public function __construct($obj)
    {
        $args = func_get_args();
        foreach ($args as $arg) {
            $this->_sendObj = $obj;
        }
    }
    public function register()
    {
        $this->_sendObj->send();
    }
}

(new User(new SendEmailBy163()))->register();
*/


/**
 * 依赖容器注入
 *
 *
$container = new Container;
$container ->set('163',function ($container,$name = '') {
    return new SendEmailBy163($name);
});

$container ->set('user',function ($container,$params = []) {
    return new User($container->get($params[0],$params[1]));
});

var_dump($s = $container->get('163','test163'));
var_dump($u = $container->get('user',['163','test']));
$u->register();

*/


/** 加入 php反射+容器注入 */
$container = new Container();
var_dump($user = $container ->get('User'));
$user->register();