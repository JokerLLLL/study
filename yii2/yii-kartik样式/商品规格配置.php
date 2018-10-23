<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use kartik\editable\Editable;
use backend\models\SmnWrapper;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel merchant\modules\item\models\MeItemValueSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '商品规格');
$this->params['breadcrumbs'][] = $this->title;

 

?>
<?=SmnWrapper::begin()?>

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <p>
         <?php // Html::a(Yii::t('app', '更新规格组合'), ['/item/me-prop/select','item_id'=>$searchModel->item_id],['class' => 'btn btn-info btn-sm']) ?> 
    </p>
     <?php  echo $this->render('_select', ['model' => $selectModel,'item_id'=>$item_id]); ?>
     
  <h3>规格组合列表</h3>   
<?php Pjax::begin(); ?>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'export' => false,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'编号'],
           
            'value_names:ntext',
            [
            'attribute' => 'stock',
            'class'=>'kartik\grid\EditableColumn',
            'format' => 'html',
            'editableOptions'=> function ($model, $key, $index) {
                return [
                    'asPopover' => false,       //是否开启弹框
                    //'size'=>'sm',
                    'formOptions' => [
                        'method'=>'post',
                        'action' => ['update-info', 'id' => $key],
                    ] ,
                    'inputType' => Editable::INPUT_TEXT,
                    //                         'format' => 'button',
                ];
            },
            'value' => function ($model) {
                return \kartik\editable\Editable::widget([
                    'name' => 'stock',
                    'value' => $model->stock,
                    'attribute' => 'stock',
                    'format' => 'button',
                ]);
            },
            
            ],
             'stock_lock',
//             'price',
            [
            'attribute' => 'price',
            'class'=>'kartik\grid\EditableColumn',
            'format' => 'html',
            'editableOptions'=> function ($model, $key, $index) {
                return [
                    'asPopover' => false,       //是否开启弹框
                    //'size'=>'sm',
                    'formOptions' => [
                        'method'=>'post',
                        'action' => ['update-info', 'id' => $key],
                    ] ,
                    'inputType' => Editable::INPUT_TEXT,
//                                             'format' => 'button',
                ];
            },
            'value' => function ($model) {
                return \kartik\editable\Editable::widget([
                    'name' => 'price',
                    'value' => $model->price,
                    'attribute' => 'price',
                    'format' => 'button',
//                     'options' => ['class' => 'form-control', 'placeholder' => 'Enter person name...'],
                ]);
            },
            
            ],
            /*[
                'attribute' => 'postage',
                'class'=>'kartik\grid\EditableColumn',
                'format' => 'html',
                'editableOptions'=> function ($model, $key, $index) {
                    return [
                        'asPopover' => false,       //是否开启弹框
                        //'size'=>'sm',
                        'formOptions' => [
                            'method'=>'post',
                            'action' => ['update-info', 'id' => $key],
                        ] ,
                        'inputType' => Editable::INPUT_TEXT,
//                                             'format' => 'button',
                    ];
                },
                'value' => function ($model) {
                    return \kartik\editable\Editable::widget([
                        'name' => 'postage',
                        'value' => $model->postage,
                        'attribute' => 'postage',
                        'format' => 'button',
//                     'options' => ['class' => 'form-control', 'placeholder' => 'Enter person name...'],
                    ]);
                },

            ],*/
            'deal_num', 
            'create_time',
            // 'postage',
        ],
 
        'layout'=>'{items} <div class="row " > <div class="col-lg-12 "><div class="col-lg-4 pagination" > {summary} </div><div class="pull-right">{pager} </div> </div></div> ',
        'pager' => [
            'firstPageLabel' => "首页",
            'prevPageLabel' => '上一页',
            'nextPageLabel' => '下一页',
            'lastPageLabel' => '最后一页',
        ],
        
        
    ]); ?>
<?php Pjax::end(); ?>
<?=SmnWrapper::end()?>
