
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
          'nullDisplay' => '-', //没有数据默认是not set 可以更改成 空字符串
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
//后台异步请求
jQuery('#category').yiiGridView({"filterUrl":"\/index.php?r=category%2Findex","filterSelector":"#category-filters input, #category-filters select"});

//后台多选删除
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
echo $form->field($modle,'test')->checkBoxList(['value1'=>'name1','value2'=>'name2','value3'=>'name3']);

echo $form->field($model,'select')->DropDownList(['1'=>'one','2'=>'two'],[
  'style'=>'','onchange'=>'$(".class").hide();if($(this).val==3){$.(".class").show();}',
  'disabled'=>true                    //只读框
]);
echo $form->field($model,'aid')->hiddenInput(['value'=>$model->aid])->label(false);


/* 时间选择 */
echo $form->field($model,'create_time')->widget(\kartik\datetime\DateTimePicker::className(), [
  'options' => ['placeholder' => ''],
  'pluginOptions'=> [
    'autoclose'=>true,
    'format'=>'yyyy-mm-dd HH:ii',
  ]
])->label('时间');


/* 日期选择 */
$form->field($model, 'create_time')->widget(\kartik\date\DatePicker::className(), [
    'language' => 'zh-CN',
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd', //yyyy选择到年，yyyy-mm到月，yyyy-mm-dd到天
        'startView'=>0,   //其实范围（0：日  1：天 2：年）
        'maxViewMode'=>2, //最大选择范围（0：日  1：天 2：年）
        'minViewMode'=>0, //最小选择范围（0：日  1：天 2：年）
    ]
])  

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

## 弹框 ##
````php
        Yii::$app->getSession()->setFlash('success', '错误');

        <?= Alert::widget() ?>
        <script>
            window.setTimeout(function() {
                $('.alert').alert('close');
            }, 3000);
        </script>
// 必须在这之前
<?=$content ?>
````