## yii2 可以使用 mysql 的 get_lock 或 flock 进行唯一锁 进行队列

```php
<?php
        //$mutex = new MysqlMutex();
        $mutex =  new FileMutex();
        $name = 'async.abc';
        $time = 10;
        if($mutex->acquire($name,$time)) {
            //加锁 开始处理异步发送消息
             // TODO...
            $mutex->release($name);
        }else{
            //过来 $time 还有执行到进行错误处理  就是TODO没有执行到
            
        }

```

