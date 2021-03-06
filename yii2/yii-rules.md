### yii2 Rule规则 核心验证器

yii的核心验证器位于yii\validators命名空间中，我们可以使用别名来使用指定的验证器。例如：required 指代了yii\validators\RequiredValidator

yii\validators\Validator::$builtInValidators 属性里申明了所以支持的属性。

```php
<?php
return [
  //检查 "selected" 是否为 0 或 1，无视数据类型
  ['selected','boolean'],

  //验证布尔 trueValue代表真值,默认1 falseValue代表假值,默认0 strict是否开启严格模式,默认false 注:html传值基本都为string,建议不要开启
  ['selected','boolean','trueValue'=>true,'falseValue'=>false,'strict'=>false],

  //该验证器通常配合 yii\captcha\CaptchaAction 以及 yii\captcha\Captcha 使用，以确保某一输入与 CAPTCHA 小部件所显示的验证代码（verification code）相同
  //caseSensitive:大小写是否敏感,默认false captchaAction:验证码路由,默认'site/captcha' skipOnEmpty:为空是否跳过验证,默认false
  ['code','captcha'],

  //compare 两字段是否相等 compareAttribute默认为password_repeat (原字段加上后缀_repeat)
  //compareValue 用于对比的值 优先级高于指定字段，存在的话就会优先去比较而忽略字段
  //operator 默认为 == 可以指定 === != < > ....等操作符号
  //type 默认为string 如果为数字 可以启用number
  ['password','compare'],
  ['re_password','compare','compareAttribute'=>'password','message'=>'两次输入不一样'],
  ['age','compare','compareValue'=>30,'operator'=>'>='],

  //日期验证 有三种不同格式 date datetime time
  //format 被验证值的日期时间格式 默认值于三种格式各不相同 参考Yii::$app->formatter->dateFormat
  //timestampAttribute 将提交的日期转成时间戳填充到指定字段
  ['creaet_time','date','timestampAttribute'=>'create_time'],

  //default 默认值 value属性可以为定值 也可以使用匿名函数
  ['age','defualt','value'=>0],
  [['from_time','to_time'],'defualt','value'=>function($model,$attribute){
     if($attribute == 'from_time'){
       return strtotime('-1 day');
     }else{
       return strtotime('+1 day');
     }
   }
  ],

  //double 双精度浮点数 max min 设置取值区间（包含max min）
  ['salary','double'],

  //each 只能验证array 不是array也会返回错误
  //rule 验证array每个元素所以配置的验证规则
  ['array','each','rule'=>['integer']],

  //email 验证邮箱正则 allowName是否代名词的email eg:joker<joker@joker.com> checkDNS 检查DNS有效性 enableIDN 是否考虑国际域名(确保intel PHP拓展安装才能打开)
  ['email','email'],

  //exist 用于AR里中的是否值是否存在的验证,输入a1的值在数据表中存在通过验证
  ['a1','exist'],
  ['a1', 'exist', 'targetAttribute'=>'a2'],  //验证a1的值是否存在a2中 存在返回true
  [['a1','a2'],'exist','targetAttribute'=>['a1','a2']], //a1 a2的值有需要存在 且都相互报错
  //数据表存在
  [['uid'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['uid' => 'id']],

  //file 文件验证 大小尺寸单位byte
  //FileValidator 通常与 yii\web\UploadedFile 共同使用
  ['image','file','extensions'=>['jpeg','jpg','png','gif'],'maxSize'=>1024*1024*10 ,'minSize'=>0],

  //filter 过滤器 name自动过滤name的空格 可以使用的过滤器 eg: trim boolval intval ...
  ['name','filter','filter'=>'trim','skipOnArray'=>true],
  [['name','email'],'filter','filter'=>function($value) {
      //自定义一个 过滤空格 且只取前5位字符的过滤器
      return substr(trim($value),0,5);
    }
  ],

  //image 验证图片
  ['image','image','extensions'=>'png,jpeg','minWith'=>100,'maxWith'=>1000,'minHeight'=>100,'maxHeight'=>1000,
  ],

  //ip验证
  ['ip','ip'],

  //in 范围 range 允许的数组
  ['level','in','range'=>['1','2','3'],

  //ingter 整数
  ['age','integer','max'=>100,'min'=>1],

  //match 正则匹配
  ['username','match','pattern'=>'/^[A-Z]\w*$/i'],

  //number 数字
  ['salary','number'],

  //required 必填字段
  ['username','required'],

  //safe 安全属性
  ['content','safe'],

  //string 字符串 length 属性大于 min max属性 encoding 默认UTF-8
  ['username','string','length'=>[0,25],'min'=>10,'max'=>100],

  //trim 空格过滤
  ['username','trim'],

  //unique 数据表中字段唯一性
  //targetClass 默认为所在AR类
  //targetAtrribute 用于检查unique唯一性的targetClass所要关联的属性 默认是所要验证属性自己
  //filer=>function($qurey){} 验证唯一性时候可以传的限制条件
  //a1 字段唯一
  ['a1','unique'],
  //a1在a2中,是否唯一
  ['a1','unique','targetAttribute'=>'a2'],
  //a1,a2组合是否唯一 且只有a1有提示
  ['a1','unique','targetAttribute'=>['a1','a2']],
  //a1,a2组合是否唯一 且a1 a2都有错误提示
  [['a1','a2'],'unique','targetAttribute'=>['a1','a2']],

];
```
这些是一些基础的验证规则，
比较实用的有 require unique number min max filter配合function  default value配合function
