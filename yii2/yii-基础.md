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

### yii components组件 GridView,DetailView(类同Grid) 和 ActiveForm (后台)
```php
<?php
Pjax::begin(); //使生成的列表分页可以进行ajax异步加载
echo GridView::widget([
    'dataProvider' => $dataProvider, //数据提供
    'filterModel' => $searchModel, //搜索字段
     'rowOptions' =>function($model) {  //条数渲染
         if(in_array($model->status, [6,7]) ){
             return ['style'=>'color:red;'];
         }
       },
      'formatter' => [
          'class' => 'yii\i18n\Formatter',
          'nullDisplay' => '', //没有数据默认是not set 可以更改成 空字符串
       ],
    'options' => ['style'=>'overflow: auto; word-wrap: break-word;','id'=>'grid'],//应用全部字段
    //字段渲染
    'columns' => [
       ['class' => 'yii\grid\SerialColumn','header'=>'编号'],//自动编号
       //条数多选框 + ajax 进行批量删除
       [
           'class'=>'yii\grid\CheckboxColumn',
           "name" => "id",
           'checkboxOptions' => function ($model, $key, $index, $column) {
               return ['value'=>$model->id,'class'=>'checkbox'];
           }
       ],
       
        //展现字段
        [
            'attribute'=>'name', //字段 可以是model表的关联字段 子查询 u.name
            'label'=>'名字', //表头标题
            'contentOptions'=>[ //字段样式
              'style'=>'word-break: break-all;white-space: normal;', //设置自动跳转段落位置
              'width'=>'12%',
            ],
            'format' => 'raw', //显示格式 raw 不处理html
            'format'=>[ //显示格式
              'image',
              [ 'width'=>'50','height'=>'50'],
            ],
            'filter'=>['1'=>'是','0'=>'否'], //在有 filterModel的时候有用
            'value'=>'u.name',//定义value的值 同attribute
            'value'=>function($model){
               return 'doing something...';
            }
        ],
        [
              'attribute' =>'url', //进过  特殊处理的视图
              'label' => '富文本',
              'filter' => Html::activeTextInput($searchModel, 'url', ['class' => 'form-control']),
              'format' => 'raw',
              'value' => function ($data) {
                  return Html::a("请求地址", $data->url);
              },
         ],
        #字段结束
        //按钮
        [
          'class'=>'yii\grid\ActionColumn',
          'header'=>'操作',
          'options'=>['with'=>'100px;'],
          'template'=>'{view1} {view2}',
          'buttons'=>[
            'view1'=>function($url,$model) {
              return Html::a('<i class="fa fa-edit">button1</i>',$url,[
                 'title'=>'edit',
                 'class'=>'del btn btn-default btn-xs',
                 'data'=>[
                   'confirm'=>Yii::t('app','yes or no?'),
                   'method'=>'post',
                 ],
              ]);
            },
            'view2'=>function($url,$model) {
              return Html::a('<i class="fa fa-edit">button2</i>','javascript:;',[
                'class'=>'button2',
                'data-value'=>$model->id,
              ]);
            }
          ]
        ]
        #按钮结束
    ],
]);
Pjax::end();
$this->beginBlock('button2');
//ajax 代码
?>
<script>

$("#grid").on('click',function(){
    var value = $('#grid').yiiGridView('getSelectedRows');
    $.ajax({
        'url':'/abc/index',
        'dataType':'json',
        'data':{name:value},
        'timeOut':2000,
        'success':function(data,status) {
            alert('abc');
            loaction.reload();
        }
    })
});

</script>

<?
$this->endBlock();
$this->registerJs($this->blocks['button2'],\yii\web\View::POS_END);
##该ajax还可以写成 js文件 在 AppAsset.php中注册

/*路由生成*/
echo Html::a('名字',['/route/route/index'],['class'=>'class','style'=>'style']);

###ActiveForm  $model(作为增改的表单使用的是AR类进行渲染的 而搜索模型是使用Search类进行渲染的)

$form = ActiveForm::begin([
  'option'=>['enctype'=>'multipart/form-data','class'=>'form-horizontal'],
  'fieldConfig' =>[
    'template'=>"{label}<div class='col-lg-7'>{input}</div><div class='col-lg-3'>{hint}{error}</div>", //生成的表达模版进行排版
    'labelOption'=>['class'=>'col-lg-2'],//给label添加 样式
  ],
  'action' => ['index'], //作为search 为路由地址 默认为生成代码的控制器为路由
  'method' => 'get',  //作为search 提交的方式 默认为post传输
]);
echo $form->field($model,'name',['option'=>['class'=>'class','style'=>'display:none']]);//可以添加样式
echo $form->field($model,'name')->textInput(['maxlength' => true])->label('姓名');
echo $from->field($model,'content')->textarea(['rows'=>3]);//编辑框
echo $from->field($model,'content')->textarea(['rows'=>3,'readonly'=>true]);//编辑框 //readonly 只读
echo $form->field($model,'select')->DropDownList(['option'=>'name']);

echo $form->field($model,'select')->DropDownList(['1'=>'one','2'=>'two'],[
  'style'=>'','onchange'=>'$(".class").hide();if($(this).val==3){$.(".class").show();}',
  'disabled'=>true                    //只读框
]);
echo $form->field($model,'aid')->hiddenInput(['value'=>$model->aid])->label(false);
echo $form->field($model,'create_time')->widget(\kartik\datetime\DateTimePicker::className(), [
  'options' => ['placeholder' => ''],
  'pluginOptions'=> [
    'autoclose'=>true,
    'format'=>'yyyy-mm-dd',
  ]
])->label('日期');
echo Html::submitButton('button',['class'=>'btn btn-primary']);
ActiveForm::end();

    //图像上传
    echo $form->field($model, 'logo_url')->widget('yidashi\webuploader\Webuploader',['server'=>'/base/pic-api/upload?pic_type=local',
        'options'=>['btnname'=>'上传头像','boxId' => 'picker1', 'previewWidth'=>250, 'previewHeight'=>250]]);
        
    //富文本编辑框
   echo  $form->field($model, 'content')->widget('kucha\ueditor\UEditor',['clientOptions' => [
                //编辑区域大小
                'initialFrameWidth' => "100%",
                'toolbars' => [[
                    'fullscreen', 'source', '|', 'undo', 'redo', '|',
                    'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
                    'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
                    'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
                    'directionalityltr', 'directionalityrtl', 'indent', '|',
                    'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
                    'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
                    'simpleupload', 'insertimage', 'emotion', 'scrawl', 'insertvideo', 'music', 'attachment', 'map', 'insertframe', 'pagebreak', 'background', '|',
                    'horizontal', 'date', 'time', 'spechars', 'snapscreen', 'wordimage', '|',
                    'help'
                ]],
            ]]); ?>
```


### yii 的日志配置模块

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


###文件上传
```php
<?php

#视图
 echo $form->field($model,'fileMark')->fileInput();
 
#控制器
$model->fileMark = UploadedFile::getInstance($model, 'fileMark');
$model->load(Yii::$app->request->post(),'');
$model->upload();
 
#模型
    //验证规则
    [['fileMark'],'file','skipOnEmpty' => true,'extensions' => ['txt','xls','xlsx','pdf','doc','docx']];
    //上传方法
    public function upload()
    {
        if ($this->validate()) {
            $root = \Yii::getAlias('@backend/web');  //给到读写权限
            $name = '/uploads/'.date('YmdHis').rand(100000,999999). '.' . $this->fileMark->extension;
            $this->fileMark->saveAs($root.$name);
            return $name;
//            return true;
        } else {
//            throw new \Exception('upload file');
            return false;
        }
    }

```