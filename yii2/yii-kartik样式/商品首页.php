<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\modules\base\models\Lookup;
use merchant\modules\shop\models\Shop;
use backend\models\SmnWrapper;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel merchant\modules\item\models\MeItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '商品列表');
$this->params['breadcrumbs'][] = $this->title;
?>
<?=SmnWrapper::begin()?>

    <h1><?= Html::encode($this->title) ?></h1>
    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', '新增商品'), ['create'], ['class' => 'btn btn-info btn-sm']) ?>
<?php if (!Yii::$app->user->can('店铺管理员')){ ?>

    <?= Html::a(Yii::t('app', '批量设置热门'), "javascript:void(0);", ['class' => 'btn btn-success btn-sm batch-set']) ?>
        <?= Html::a(Yii::t('app', '批量取消热门'), "javascript:void(0);", ['class' => 'btn btn-default btn-sm batch-unset']) ?>
            <?= Html::a(Yii::t('app', '批量设置新品'), "javascript:void(0);", ['class' => 'btn btn-success btn-sm new-set']) ?>
            <?= Html::a(Yii::t('app', '批量取消新品'), "javascript:void(0);", ['class' => 'btn btn-default btn-sm new-unset']) ?>
        <?= Html::a(Yii::t('app', '批量上架'), "javascript:void(0);", ['class' => 'btn btn-success btn-sm batch-shelf']) ?>
    <?php }else{ ?>
            <?= Html::a(Yii::t('app', '批量待上架审核'), "javascript:void(0);", ['class' => 'btn btn-success btn-sm batch-shelf-shop']) ?>
    <?php } ?>
        <?= Html::a(Yii::t('app', '批量下架'), "javascript:void(0);", ['class' => 'btn btn-default btn-sm batch-unshelf']) ?>
    </p>
<?php Pjax::begin(); ?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'export' => false,
    'options' => [
        'class' => 'grid-view',
        'style' => 'overflow:auto',
        'id' => 'grid',
    ],
//        'filterModel' => $searchModel,
    'columns' => [
        [
            'class' => 'kartik\grid\CheckboxColumn',
            'headerOptions' => ['class' => 'kartik-sheet-style'],
            'name' => 'item_id',
        ],
        ['class' => 'kartik\grid\SerialColumn','header'=>'编号'],

        /**
         * 展开图详情
         */

        [
            'class' => 'kartik\grid\ExpandRowColumn',
            'width' => '50px',
            'value' => function ($model, $key, $index, $column) {
                return GridView::ROW_COLLAPSED;
            },
            'detail' => function ($model, $key, $index, $column) {
                return Yii::$app->controller->renderPartial('_expand-row-details', ['model' => $model]);
            },
            'headerOptions' => ['class' => 'kartik-sheet-style'],
            'expandOneOnly' => true
        ],
        [
            'label' => '展示图片',
            'format' => [
                'image',
                [
                    'width'=>'80',
                    'height'=>'80'
                ]
            ],
            'value' => function ($model) {

                return $model->img_url;
            }
        ],
        [
            'attribute' =>'shop_id',
            'label' =>'商家',
            'headerOptions' => ['class' => 'kartik-sheet-style'],
//            'contentOptions' => ['style' => 'word-break: break-all;white-space: normal;', 'width' => '10%'],
            'group'=>true,  // enable grouping
            'value' =>function($model){
                return Shop::item($model ->shop_id);
            }
        ],
        [
            'attribute' =>'title',
//            'headerOptions' => ['class' => 'kartik-sheet-style'],
            'contentOptions' => ['style' => 'word-break: break-all;white-space: normal;', 'width' => '10%'],
        ],
        [
            'attribute' =>'item_code',
            'headerOptions' => ['class' => 'kartik-sheet-style'],
            'value' => function ($model) {
                return "<code>" . $model->item_code . '</code>';
            },
            'format' => 'raw',
//            'contentOptions' => ['style' => 'word-break: break-all;white-space: normal;', 'width' => '10%'],
        ],

        'price',
//        'market_price',
        'stock',
        'deal_num',
        [
            'attribute' =>'is_hot',
            'class' => 'kartik\grid\BooleanColumn',
            'trueLabel' => 1,
            'falseLabel' => 0,
        ],
        [
            'attribute' =>'is_new',
            'class' => 'kartik\grid\BooleanColumn',
            'trueLabel' => 1,
            'falseLabel' => 0,
            'label' =>'是否新品',
        ],
        [
            'attribute' =>'status',
            'label' =>'上架状态',
            //             'contentOptions' => ['style' => 'word-break: break-all;white-space: normal;', 'width' => '15%'],
            'value' =>function($model){
//                return "<code>" . Lookup::item('item-status', $model->status) . '</code>';
                return Lookup::itemHtml('item-status', $model->status, [5=>'success',7=>'default',4=>'default',1=>'default']);
            },
            'format' => 'raw',
        ],
//        'create_time',
        [
            'attribute' => 'create_time',
            'headerOptions' => ['class' => 'kartik-sheet-style'],
//            'contentOptions' => ['style' => 'word-break: break-all;white-space: normal;', 'width' => '12%'],
        ],
        [
            'class' => 'kartik\grid\ActionColumn',
            'header' => '操作',
            'headerOptions' => ['class' => 'kartik-sheet-style'],
//            'options' => ['width' => '100px;'],
            'template' => '{values} {update} {delete}<br/>  {add-nature}',
            'buttons' => [

                'add-nature' => function ($url, $model,$key) {
                return Html::a('服务描述', ['me-item-nature/index','item_id'=>$key], [
                    'title' => Yii::t('app', 'view'),
                    'class' => 'del btn btn-info btn-xs',
                ]);
                },

                'view' => function ($url, $model) {
                    return Html::a('查看', $url, [
                        'title' => Yii::t('app', 'view'),
                        'class' => 'del btn btn-primary btn-xs',
                    ]);
                },
                'update' => function ($url, $model) {
                    return Html::a('更新', $url, [
                        'title' => Yii::t('app', 'update'),
                        'class' => 'del btn btn-success btn-xs',
                    ]);
                },
                'delete' => function ($url, $model) {
                    return Html::a('删除', $url, [
                        'title' => Yii::t('app', 'delete'),
                        'class' => 'del btn btn-default btn-xs',
                        'data' => [
                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ]);
                },
                'values' => function ($url,  $model) {
                    return Html::a('规格配置', '/item/me-item-value/index?item_id=' . $model->item_id, [
                        'title' => Yii::t('app', 'values'),
                        'class' => 'del btn btn-primary btn-xs',
                        'data' => [
                            'method' => 'post',
                        ],
                        'style' => 'margin-left:0.2rem;',
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
<?php Pjax::end(); ?>
<?=SmnWrapper::end()?>

<?php
$url = Yii::$app->urlManager->createUrl('item/hot-item/batch-set').'?url=/item/me-item/index&ids=';
$unset_url = Yii::$app->urlManager->createUrl('item/hot-item/batch-unset').'?url=/item/me-item/index&ids=';
$shelf_url = Yii::$app->urlManager->createUrl('item/item-shelf/batch-shelf').'?url=/item/me-item/index&ids=';
$shelf_url_shop = Yii::$app->urlManager->createUrl('item/item-shelf/batch-shelf-shop').'?url=/item/me-item/index&ids=';
$unshelf_url = Yii::$app->urlManager->createUrl('item/item-shelf/batch-unshelf').'?url=/item/me-item/index&ids=';
$new_url = Yii::$app->urlManager->createUrl('item/item-new/new-set').'?url=/item/me-item/index&ids=';
$unnew_url = Yii::$app->urlManager->createUrl('item/item-new/new-unset').'?url=/item/me-item/index&ids=';
$js = <<<JS
    function myDialog(url){
        //获取选中的标签
        var keys = $('#grid').yiiGridView('getSelectedRows');
        if (!$.isArray(keys) || keys.length < 1) {
            parent.layer.msg('请先选择!');
            return false;
        }
        
        //询问框
        parent.layer.confirm('是否确认选择设置？', {
            btn: ['确认','取消'], //按钮
            shade: false //不显示遮罩
        }, function(){
            parent.layer.closeAll('dialog');    //关闭dialog
            $(window).attr('location',url+keys);
        }, function(){
            //取消   什么都不做
        });
    }
    //批量热门设置
    $(document).on('click', '.batch-set', function(){
        myDialog("$url");
    });
    
    $(document).on('click', '.batch-unset', function() {
        myDialog("$unset_url");
    });
    //批量上架设置
    $(document).on('click', '.batch-shelf', function(){
        myDialog("$shelf_url");
    });
    //批量待上架设置
    $(document).on('click', '.batch-shelf-shop', function(){
        myDialog("$shelf_url_shop");
    });
    $(document).on('click', '.batch-unshelf', function() {
        myDialog("$unshelf_url");
    });
    //批量新品设置
    $(document).on('click', '.new-set', function(){
        myDialog("$new_url");
    });
    $(document).on('click', '.new-unset', function() {
        myDialog("$unnew_url");
    });
JS;
$this->registerJs($js);


/**   批量设置方法
public function actionNewSet($ids,$url = '/item/me-item/index')
{
$ids = explode(',',$ids);
$ret = ItemService::newSet($ids);
if (!$ret['status']) {
Yii::$app->getSession()->setFlash('error', $ret['info']);
return $this->redirect([$url]);
}
Yii::$app->getSession()->setFlash('success', '设置成功');

return $this->redirect([$url]);
}
 */
?>