<?php
use merchant\modules\shop\services\ShopService;
use yii\helpers\Html;
use merchant\modules\item\services\ItemService;
?>
<?=Html::cssFile('@web/js/plugins/fancybox/jquery.fancybox.css')?>
<style>
    .sep-line{
        z-index: 1;
        position: relative;
        margin: 10px 0 20px;
        height: 1px;
        border-bottom: 1px dotted #D9D9D9;
        overflow: hidden;
    }
</style>
<div class="kv-detail-content">
    <div class="row">
        <div class="col-sm-4">
            <div class="img-thumbnail img-rounded text-center">
                <div class="fancybox" href="<?= $model->img_url?>" title="<?=$model->title?>">
                    <img src="<?= $model->img_url?>" style="padding:2px;width:320px;height:320px">
                </div>
            </div>

        </div>
        <div class="col-sm-8">
            <div class="img-thumbnail img-rounded">
                <p>
                <span class="label label-danger"><?=ShopService::getName($model->shop_id)?></span>&nbsp;<strong><?=$model->title?><?="（{$model->remark}）"?></strong>
                </p>

                <h3 class="m-t-lg"><span class="badge">单价</span> <span class="m-t-lg"><?=$model->price?></span></h3>

                <div class="sep-line"></div>
                <?php foreach ( ItemService::getSkus($model->item_id) as $item):?>
                    <div class="col-sm-12">
                        <div class="col-sm-2"><?=$item['prop_name']?></div>
                        <div class="col-sm-10 img-thumbnail">
                            <?php foreach ( $item['children'] as $value_info):?>
                            <span class="label label-default" style="padding-right:5px"><?=$value_info['value_name']?></span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
<!--        <div class="col-sm-1">-->
<!--            <div class="kv-button-stack">-->
<!--                <button class="btn btn-outline btn-danger  dim " type="button"><i class="fa fa-heart"></i>-->
<!--                </button>-->
<!--                <button class="btn btn-primary dim" type="button"><i class="fa fa-check"></i>-->
<!--                </button>-->
<!--            </div>-->
<!--        </div>-->
    </div>
</div>

<?=Html::jsFile('@web/js/plugins/fancybox/jquery.fancybox.js')?>
<script>
    $(document).ready(function(){$(".fancybox").fancybox({openEffect:"none",closeEffect:"none"})});
</script>
