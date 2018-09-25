
## yii 的日志配置模块 ##

```sql
drop table if exists `log`;

create table `log`
(
   `id`          bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
   `level`       integer,
   `category`    varchar(255),
   `log_time`    double,
   `prefix`      text,
   `message`     text,
   key `idx_log_level` (`level`),
   key `idx_log_category` (`category`)
) engine InnoDB;

```

配置:
```php
<?php
//配置文件里的写法  'categories'也可以写出 yii\base\*  等一些类名 发送错误时纪录
       [ 'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [       //错误日志
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info'],
                    'categories' => ['test'],
                    'logFile' => '@backend/runtime/logs/band/test.log',
                    'maxFileSize' => 1024 * 2,
                    'maxLogFiles' => 20,
                ],
                [
                    'class'=>'yii\log\DbTarget',
                    'logVars' => [''], //可追加的 _SERVER _COOKIE 等 
                    'levels'=>['info','error','warning'],
                    'categories'=>['category'],
                ]
            ],
        ];
       
              //触发记入日志
               \Yii::info($msg,'category');

```

## 邮件模块 ##

配置：
```php
<?php

'mailer' => [ 
    'class' => 'yii\swiftmailer\Mailer', 
    'viewPath' => '@common/mail', 
    // 这个要设置为false,才会真正的发邮件 
    'useFileTransport' => false, 
    'transport' => [ 
        'class' => 'Swift_SmtpTransport', 
        // 如果是163邮箱，host改为smtp.163.com
        'host' => 'smtp.qq.com', 
        // 邮箱登录帐号
        'username' => '422744746@qq.com',
        // 如果是qq邮箱，这里要填写第三方授权码，而不是你的qq登录密码，参考qq邮箱的帮助文档
        //http://service.mail.qq.com/cgi-bin/help?subtype=1&&id=28&&no=1001256
        'password' => '******', 
        'port' => '25', 
        'encryption' => 'tls', 
    ], 
    'messageConfig'=>[ 
        'charset'=>'UTF-8', 
        'from'=>['422744746@qq.com'=>'白狼栈'] 
    ], 
],

public static function sendMail($event)
{
    $mail= Yii::$app->mailer->compose(); 
    $mail->setTo('***@qq.com'); //要发送给那个人的邮箱 
    $mail->setSubject("邮件主题"); //邮件主题 
    $mail->attach('图片可访问地址'); 
    $mail->attachContent('Attachment content', ['fileName' => 'attach.txt', 'contentType' => 'text/plain']);
    $mail->setTextBody('测试text'); //发布纯文字文本 
    $mail->setHtmlBody("测试html text"); //发送的消息内容 
    //var_dump($mail->send());

    return $mail->send();
}

public static function multipleSendEmail($event)
{
    $user = ['aa@qq.com','bb@qq.com'];
    $message = [];
    foreach ($user as $u) {
        $message[] = Yii::$app->mailer->compose()
        ->setTo($u)
        ->setSubject('subject')
        ->setTextBody('body')
        ->setHtmlBody('body2');
    }
    return Yii::$app->mailer->sendMultiple($message);
}

```


## 缓存配置 ##

```php
<?php
'components' => [
    'cache' => [
        'class' => 'yii\caching\FileCache',
    ],
],


//项目中使用
$cache = Yii::$app->cache;
// 尝试从缓存中取回 $data 
$data = $cache->get($key);

if ($data === false) {

    // $data 在缓存中没有找到，则重新获取这个值
    // $data = 数据库获取并处理
    // 将 $data 存放到缓存供下次使用
    $cache->set($key, $data);
}



//yii 2.0.11 之后封装 getOrSet($key, $closure, $duration=null, $dependency=null) 方法
/**@example:@*/

public function getOrSet($key, \Closure $closure, $duration=null, $dependency=null)
{
     if($value = $this->get($key) !== false) {
         return $value;
     }
     
     $value = call_user_func_array($closure,$this);
     if(!$this->set($key,$value,$duration,$dependency)) {
         Yii::warnning('set key failed:'.json_encode($value),__METHOD__);
     }
     return $value; 
}

/**
 *  开发代码
 */
$cache = Yii::$app->cache;
$cache->getOrSet($key,function ()use($data) {
       //l
    return $data;
}, 24*60*60,new TagDependecy(['tag'=>'mark']));

//使缓存失效
TagDependecy::invalidate($cache,'mark');

```
