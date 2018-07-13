```php
<?php

\yii\grid\GridView::widget([
   'dataProvider' =>$dataProvider,
   'rowOptions' =>function($model) {
     if(in_array($model->status, [6,7]) ){
         return ['style'=>'color:red;'];
     }
   },
   'columns' =>[
      ['class'=>'yii\grid\SerialColumn','header'=>'编号'],
      [
          'attribute'=>'img_url',
          'label'=>"商品图片",
          'format'=>[
              'image',
              ['width'=>60,'height'=>80],
          ],
      ],
      '一般字段',
      [
          'attribute' => '',
          'value' => function($model){
              return $model->status=='yes'?1:2;
          },
          //下拉菜单
          'filter'=>[
            '1'=>'xxx',
            '2'=>'ccc',
          ],
      ],
      [
         'attribute'=>'status',
         'label'=>"价格单位",
         'value'=>function($model){
               return Lookup::item('order-status',$model->status);
         }
      ],
      [
          'attribute' =>'content',
          'label' => '富文本介绍',
          'format' => 'raw',
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
      [
          'class' => 'yii\grid\ActionColumn',
          'header' => '操作',
          'options' => ['width' => '100px;'],
          'template' => '{view}<p> {路由}{update-postage} {send-out}</p> ',
          'buttons' => [
              'view' => function ($url, $model) {
                  return Html::a('<i class="fa fa-edit">查看</i>', $url, [
                      'title' => Yii::t('app', 'view'),
                      'class' => 'del btn btn-primary btn-xs',
                  ]);
              },
              '路由'=>function($url,$model){
              if ($model->status==2) {
                  return Html::a('名称',$url,[
                      'title'=>'',
                      'class' => 'del btn btn-success btn-xs',
                      'data' =>[
                        'confirm' => '',
                        'method' => 'post',
                      ]
                  ]);
              }

              },
              'delete' => function ($url, $model) {
                  return Html::a('<i class="fa fa-close">删除</i>', $url, [
                      'title' => Yii::t('app', 'delete'),
                      'class' => 'del btn btn-default btn-xs',
                      'data' => [
                          'confirm' => Yii::t('app', '你确定要删除吗?'),
                          'method' => 'post',
                      ],
                  ]);
              }
          ],
          /*'urlCreator' => function ($action, $model, $key, $index) {
          if ($action === 'view') {
          return ['view', 'id' => $model->id];
          } else if ($action === 'update') {
          return ['update', 'id' => $model->id];
          } else if ($action === 'delete') {
          return ['delete', 'id' => $model->id];
          }
          }*/
      ],


   ]

?>
<!-- _search 重写 -->
<div class="row">
    <div class="col-md-4">
        <?= $form->field($model, 'order_no')->dropDownList(array_merge([""=>"全部"],MePostage::getStatus([]))) ->label('订单状态') ?>
    </div>
    <div class="col-md-4">
      <?= $form
          ->field($model, 'update_time')
          ->widget(\kartik\datetime\DateTimePicker::className(), [
              'options' => ['placeholder' => ''],
              'pluginOptions' => [
                'autoclose' => true,
                'format' =>'yyyy-mm-dd',
               ]
            ])
          ->label('结束时间');
        ?>
      </div>
</div>
