<?php
/** 缓存用主键封装
 * Created by PhpStorm.
 * User: jokerl
 * Date: 2018/10/25
 * Time: 9:12
 */

namespace backend\components;


class CacheHelper
{
     public static $cache;

    /** 获取缓存
     * @param $key
     * @return mixed
     */
     public static function get($key)
     {
          if(!self::$cache) {
              self::$cache = \Yii::$app->cache;
          }
          return self::$cache->get($key);
     }

    /** 设置缓存
     * @param $key
     * @param $value
     * @param int $timeout
     * @param null $dependency
     * @return bool
     */
     public static function set($key,$value,$timeout = 0,$dependency = null)
     {
         if(!self::$cache) {
             self::$cache = \Yii::$app->cache;
         }
         return self::$cache->set($key, $value, $timeout, $dependency);
     }


    /** 缓存设置
     * @param $key
     * @param \Closure $closure
     * @param int $duration
     * @param null $dependency
     * @return bool|mixed
     */
        public static function getOrSet($key, \Closure $closure, $duration = 0, $dependency=null)
        {
            if(($value = self::get($key)) !== false) {
                return $value;
            }

            $value = call_user_func($closure);
            if(!self::set($key,$value,$duration,$dependency)) {
                \Yii::warning('set key failed:'.json_encode($value),__METHOD__);
            }
            return $value;
        }

}