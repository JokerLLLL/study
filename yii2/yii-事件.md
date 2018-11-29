# 事件的使用 

yii 要使用事件要继承 yii\base\Component;

```php
<?php

class TestService extends Component
{
      const TEST_EVENT_1 =  'test_event_1';
      public function init(){
          //可以绑定一些事件
          $data = 'some data ...';
          $this->on(self::TEST_EVENT_1,['ClassA','func1'],$data); //$data 触发前会被 赋给$event->data属性
          $this->on(self::TEST_EVENT_1,['ClassA','func2'],$data); //可重复绑定
          parent::init();
      }
      
      public function Hello()
      {
           $event = new EVENT();          
           $this->trigger(self::TEST_EVENT_1,$event);
      }   
}

//事件处理函数
class ClassA{
    
    // 这个函数其实由于 call_user_fun() 去唤醒 所以 一开始 call_user_fun($callback,$event); 对于$event 
    // 的传值就已经设置好了
    public function func1($event)
    {
        var_dump($event->data);
    }
    
    public static function fun2($event)
    {
        var_dump($event->data);
    }
}

//e.g.
$this->trigger(self::EVENT_AFTER_LOGIN, new UserEvent([
    'identity' => $identity,
    'cookieBased' => $cookieBased,
    'duration' => $duration,
    STDOUT
]));
```
