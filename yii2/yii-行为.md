## yii的行为 ##

不改变继承关系对现有类进行扩充 ，yii中 只有继承 yii\base\Component类的才能扩充.
而扩充的方法属性 只有是 yii\baseBehavior的子类。

eg:
列如在
BlogController中:
会调用 beforeAction方法 要改造他，只自需要 在 behavior方法配置一个自定义的行为类

```php
<?php
class BlogController extends Controller{
    
    //控制器中
    public function behavior()
    {
        return [
            'behavior1'=>[
                'class'=>HelpBehavior::className(),
                'property'=>'value1' //HelpBehavior存在的属性  不同于 Yii::createObject() 配置
            ],
            'behavior12'=>[
                'class'=>HelpBehavior::className(),
                'property'=>'value2' //HelpBehavior存在的属性  不同于 Yii::createObject() 配置
            ],                
        ];
    }
    
    public function actionTest()
    {
         $this->test();   //此方法被重新
         parent::test();  //这样才触发 绑定的 行为方法 
    }
    
    public function test()
    {
        var_dump($this->property);  //输出value1 第一次绑定的行为方法和属性
    }

}

//行为类中的属性方法：
class HelpBehavior extends ActionFilter
{

    public $property;
    
    public function beforeAction($action)
    {
        var_dump($this->property);
        return true;
    }
    
    //behavior里的test方法
    public function test()
    {
        var_dump('behavior:'.$this->property);
       
    }
}
```
@说明 yii的绑定行为就如同关系继承一样 可以重写 可以父类调；



## 通过行为进行Rbac权限控制 ##

```text
    1.  获取路由
            var_dump(\Yii::$app->requestedRoute); //请求的路由地址
            var_dump(\Yii::$app->request->url);//会带上?name=value 带上参数
            $actionId = $action->getUniqueId(); 
            $requestRoute = '/'.$actionId; //请求的路由地址

    2.  获取用户
            $user_id = Yii::$app->user->id;
            
    3.  获取路由
            $routes = [];
            $manager = Yii::$app->getAuthManager();
            foreach ($manager->getPermissionsByUser($user_id) as $name => $value) {
                if ($name{0} === '/') {
                    $routes[] = $name;
                }
            }
    4.  对吧路由
        if(in_array($requestRoute,$routes) {
            return true;
        }       
        throw new ForbiddenHttpException('无权限访问！');
```

## 在yii配置中配置 ##
