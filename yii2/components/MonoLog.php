<?php
/**
 * Created by PhpStorm.
 * User: jokerl
 * Date: 2019/2/20
 * Time: 16:52
 */

namespace common\components;


use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class MonoLog
{

    /** monolog文件日志
     * @param $name
     * @param $content
     */
    public static function fileLog($name, $content)
       {
           $log = new Logger('name:');
           $log->pushHandler(new StreamHandler(__DIR__.'/file_'.date('Ymd').'.log', Logger::WARNING));
           if(!is_array($content)) {
               $content = [$content];
           }
           $log->addAlert($name,$content);
       }
}