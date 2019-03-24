<?php
/**
 * Created by PhpStorm.
 * User: JokerL
 * Date: 2019/3/24
 * Time: 22:20
 */


class RedisLock2{
     /* @var Redis */
     private  $redis = null;
     private $lockedNames = [];

    /** 单例
     * @return Redis
     */
    public function getInstance()
     {
         if($this->redis === null) {
             $this->redis = new Redis('127.0.0.1', 6379);
             $this->redis->auth('xxxx');
         }
         return $this->redis;
     }

    /** 上锁
     * @param string $name 锁名
     * @param int $timeout  等待时间 秒
     * @param int $expire   过期时间 秒
     * @param int $waitIntervalUs  微秒
     * @return bool
     */
    public function lock($name, $timeout = 0, $expire = 15, $waitIntervalUs = 100000) {
         if ($name == null) return false;
         //取得当前时间
         $now = time();
         //获取锁失败时的等待超时时刻
         $timeoutAt = $now + $timeout;
         //锁的最大生存时刻
         $expireAt = $now + $expire;
         $redisKey = "Lock:{$name}";
         while (true) {
             //将rediskey的最大生存时刻存到redis里，过了这个时刻该锁会被自动释放
             $result = $this->getInstance()->setnx($redisKey, $expireAt);
             if ($result != false) {
                 //设置key的失效时间
                 $this->getInstance()->expire($redisKey, $expireAt);
                 //将锁标志放到lockedNames数组里
                 $this->lockedNames[$name] = $expireAt;
                 return true;
             }
             //以秒为单位，返回给定key的剩余生存时间
             $ttl = $this->getInstance()->ttl($redisKey);
             //ttl小于0 表示key上没有设置生存时间（key是不会不存在的，因为前面setnx会自动创建）
             //如果出现这种状况，那就是进程的某个实例setnx成功后 crash 导致紧跟着的expire没有被调用
             //这时可以直接设置expire并把锁纳为己用
             if ($ttl < 0) {
                 $this->getInstance()->set($redisKey, $expireAt);
                 $this->lockedNames[$name] = $expireAt;
                 return true;
             }
             /*****循环请求锁部分*****/
             //如果没设置锁失败的等待时间 或者 已超过最大等待时间了，那就退出
             if ($timeout <= 0 || $timeoutAt < microtime(true)) break;
             //隔 $waitIntervalUs 后继续 请求
             usleep($waitIntervalUs);
         }
         return false;
     }


    /** 解锁
     * @param $name
     * @return bool
     */
    public function unlock($name)
    {
        //先判断是否存在此锁
        if ($this->isLocking($name)) {
            //删除锁
            if ($this->getInstance()->delete("Lock:$name") !== 0) {
                //清掉lockedNames里的锁标志
                unset($this->lockedNames[$name]);
                return true;
            }
        }
        return false;
    }

    /**
     * 释放当前所有获得的锁
     */
    public function unlockAll()
    {
        //此标志是用来标志是否释放所有锁成功
        $allSuccess = true;
        foreach ($this->lockedNames as $name => $expireAt) {
            if (false === $this->unlock($name)) {
                $allSuccess = false;
            }
        }
        return $allSuccess;
    }


    /** 给当前所增加指定生存时间，必须大于0
     * @param $name
     * @param $expire
     * @return bool
     */
    public function expire($name, $expire)
    {
        //先判断是否存在该锁
        if ($this->isLocking($name)) {
            //所指定的生存时间必须大于0
            $expire = max($expire, 1);
            //增加锁生存时间
            if ($this->getInstance()->expire("Lock:$name", $expire)) {
                return true;
            }
        }
        return false;
    }

    /**
     * 判断当前是否拥有指定名字的所
     * @param  [type]  $name [description]
     * @return boolean       [description]
     */
    public function isLocking($name)
    {
        return $this->getInstance()->get("Lock:$name");
    }
}