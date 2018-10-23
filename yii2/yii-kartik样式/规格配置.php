<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\editable\Editable;
use backend\modules\base\models\Lookup;
use merchant\modules\item\models\MePropValue;
/* @var $this yii\web\View */
/* @var $searchModel merchant\modules\item\models\MePropSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Me Props');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">

    <h1><?php // Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Me Prop'), ['create'], ['class' => 'btn btn-info btn-sm']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'export' => false,
//         'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn','header'=>'编号'],

//             'prop_id',
//             'shop_id',
//             'prop_name',
            [
                'attribute' => 'prop_name',
                'class'=>'kartik\grid\EditableColumn',
                'format' => 'html',
                'editableOptions'=> function ($model, $key, $index) {
                    return [
                        'asPopover' => true,       //是否开启弹框
                        //'size'=>'sm',
                        'formOptions' => [
                            'method'=>'post',
                            'action' => ['update-info', 'id' => $key], //提交的路由地址
                        ] ,
                        'inputType' => Editable::INPUT_TEXT,
                        //                         'format' => 'button',
                    ];
                },
                'value' => function ($model) {
                    return  Editable::widget([
                        'name' => 'prop_name',
                        'value' => $model->prop_name,
                        'attribute' => 'prop_name',
                        'format' => 'button',
                    ]);
                },
            
            ],

            /*  update-info 实现
                     public function actionUpdateInfo($id)
                    {
                        $model = $this->findModel($id);
                        $getdata = Yii::$app->request->post();
                        if (!empty($getdata['MeProp'][0]['prop_name']))
                        {
                            $model->prop_name = $getdata['MeProp'][0]['prop_name'];
                            $model->save();
                            echo \yii\helpers\Json::encode(['status' => "ok", 'prop_name'=> $model->prop_name]);
                            return ;
                        }
                        if (!empty($getdata['MeProp'][0]['sort']))
                        {
                            $model->sort = $getdata['MeProp'][0]['sort'];
                            $model->save();
                            echo \yii\helpers\Json::encode(['status' => "ok", 'sort'=>$model->sort]);
                            return ;
                        }

                        if (isset($getdata['MeProp'][0]['is_show']))
                        {
                            $model->is_show = $getdata['MeProp'][0]['is_show'];
                            $model->save();

                        }

                        echo \yii\helpers\Json::encode(['status' => "ok", 'is_show'=>$model->is_show]);

                        return ;
                    }
             *
             * */



            
//             'prop_code',
//             'remark',
//             'sort',
            [
            'attribute' => 'sort',
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
                return  Editable::widget([
                    'name' => 'sort',
                    'value' => $model->sort,
                    'attribute' => 'sort',
                    'format' => 'button',
                ]);
            },
            
            ],
            
          
            
            
            
            
            [
                 
                'label' => '下级规格',
                'format'=>'raw',
                'value' => function ($model,$key) {
                    
                    return Html::a('下级规格（'.MePropValue::sonNum($key).'）', ['/item/me-prop-value/index?prop_id='.$key], ['title' => '审核']);
                    //;
                }
            ],
            
            
            
            

            [
                'attribute' => 'is_show',
                'label' => '显示状态',
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
                        'inputType' => Editable::INPUT_DROPDOWN_LIST,
                        'data'=>Lookup::items('is-not'),
                        //                         'format' => 'button',
                    ];
                },
                'value' => function ($model) {
                    return  Editable::widget([
                        'name' => 'is_show',
                        'value' => Lookup::item('is-not', $model->is_show),
                        'attribute' => 'is_show',
                        'format' => 'button',
                    ]);
                },
            
            ],
            'create_time',
            // 'update_time',
            // 'is_show',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => '操作',
                'options' => ['width' => '100px;'],
                'template' => '',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<i class="fa fa-edit">查看</i>', $url, [
                            'title' => Yii::t('app', 'view'),
                            'class' => 'del btn btn-primary btn-xs',
                        ]);
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<i class="fa fa-unlock-alt">更新</i>', $url, [
                            'title' => Yii::t('app', 'update'),
                            'class' => 'del btn btn-success btn-xs',
                        ]);
                    },
                    'delete' => function ($url, $model) {
                        return Html::a('删除', $url, [
                            'title' => Yii::t('app', 'delete'),
                            'class' => 'del btn btn-default btn-xs',
                            'data' => [
                                'confirm' => Yii::t('app', '确认删除该规格以及其下面的所有属性'),
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


        ],
          'layout'=>'{items} <div class="row " > <div class="col-lg-12 "><div class="col-lg-4 pagination" > {summary} </div><div class="pull-right">{pager} </div> </div></div> ',
        'pager' => [
            'firstPageLabel' => "首页",
            'prevPageLabel' => '上一页',
            'nextPageLabel' => '下一页',
            'lastPageLabel' => '最后一页',
        ],
    ]); ?>
<?php Pjax::end(); ?>                </div>
            </div>
        </div>
    </div>
</div>
