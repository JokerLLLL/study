<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model merchant\modules\item\models\MeProp */
/* @var $form yii\widgets\ActiveForm */
?>



<div class="wrapper wrapper-content">

    <div class="ibox-content">

   

     <div class="me-prop-form">
  
     <?php $form = ActiveForm::begin([
//          'action' => ['save-select'],
        'options'=>['enctype'=>'multipart/form-data','class' => 'form-horizontal'],
       'fieldConfig' => [    
            'template' => "{label}<div class='col-lg-7'>{input}</div><div class='col-lg-3'>{hint}{error}</div>",    
           
           
            'labelOptions' => ['class' => 'col-lg-2 '],  
//            'hintOptions' => ['class' => 'col-lg-1 '],
        ]]); ?> 
   
    
    
       <div class="row ">

                        <div class="col-lg-12">
                             
                          <div class="ibox float-e-margins border-bottom">
                <div class="ibox-title">
                    
                     <div class="form-group" style="float:left" >
         <?php // Html::a(Yii::t('app', '新增规格'), ['/item/me-prop/index'], ['class' => 'btn btn-info btn-sm']) ?>
        
        <?= Html::submitButton("配置/更新规格组合", ['class' => 'btn btn-warning btn-sm']) ?> *:更新规格组合会清除掉原配置的规格参数数据，请谨慎更新
    </div>
     
      
    
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-down"></i>
                        </a> 
                    </div>
                </div>
                <div class="ibox-content" style="display: none;">
                    <?= $form->field($model, 'price')->textInput() ?>
                    <?= $form->field($model, 'stock')->textInput() ?>
                    <?php /*= $form->field($model, 'postage')->textInput() */ ?>
                      <?= $form->field($model, 'cate_list')->hiddenInput(['class'=>'form-control cate-list'])->label("规格选择：") ?>
    <div class="form-group">
        <div class="col-md-offset-2">
            <?php echo $this->render('./typetree', ['item_id' => $item_id]); ?>
        </div>
    </div>                
                                      

                                </div>
                            </div>
                        </div>

                    </div>
                    
    
 

   

    <?php ActiveForm::end(); ?>

</div>

    </div>

</div>

   <script src="/js/jquery.min.js?v=2.1.4"></script>
    <script src="/js/bootstrap.min.js?v=3.3.6"></script>
    <script src="/js/content.min.js?v=1.0.0"></script>
    
