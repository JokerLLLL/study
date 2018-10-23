<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\modules\base\models\Lookup;
 
 
/* @var $this yii\web\View */
/* @var $searchModel backend\modules\devices\models\DevicesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$type = 0;
if(Yii::$app->user->can('渠道管理员')) {
    $type = 1;
}elseif (Yii::$app->user->can('校区管理员')) {
    $type = 2;
}

$this->title = Yii::t('app', '批量导入');
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true"></span></button>
                <h2 class="modal-title" id="myModalLabel">excel批量导入数据</h2>
            </div>
            <div class="modal-body">
                <?= Html::a(Yii::t('app', '下载模板'), ['/excel/rooms.xls'], ['class' => 'btn btn-primary pull-right']) ?>
                <?php $form = ActiveForm::begin([
                    'action' => ['lead-excel'],
                    'method' => 'post',
                    'options' => ['enctype' => 'multipart/form-data'],
                ]); ?>

                <?= $form->field($model, 'school_id')->dropDownList([''=>'--请选择--']+\backend\modules\school\models\School::items($model->shop_id),[
                    'onchange'=>'
            $(".form-group.field-docuserdata-c_id").show();
            $.post("'.yii::$app->urlManager->createUrl('base/district-api/building').'?school_id="+$(this).val(),function(data){
                $("select#schoolroom-building_no").html(data);
        });',
                    'disabled'=>$type == 2?true:false
                ]) ?>

                <?= $form->field($model, 'building_no')->dropDownList([''=>'--请选择--']+\backend\modules\school\models\SchoolBuiding::items($model->school_id)) ?>

                <div class="col-md-4">
                     <input type="file" id="membersearch-file" name="file" accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
                </div>
                <div class="modal-footer">

                    <div class=" modal-footer form-group col-md-12 " style="text-align: center">
                        <?= Html::submitButton(Yii::t('app', '导入excel'), ['class' => 'btn btn-success data-search']) ?>
                        <p>*说明：请下载模板，依据模板规则生成excel文件 ,导入excel之后会生成一个错误信息excel表返回，依据错误提示信息，重新导入错误返回的数据即可。</p>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
 