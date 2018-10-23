<?php
use yii\helpers\Html;
use frontend\assets\AppAsset;
use yii\helpers\Url;
AppAsset::register ( $this );

$this->registerJsFile ( yii\helpers\Url::base () . '/zTree/js/jquery.ztree.all.min.js', [ 
		'depends' => 'yii\web\YiiAsset' 
] );

$this->registerJsFile ( yii\helpers\Url::base () . '/js/typetree.js?v=1.0.7', [
		'depends' => 'yii\web\YiiAsset' 
] );

$this->registerCssFile ( yii\helpers\Url::base () . '/zTree/css/metroStyle/metroStyle.css', [ 
		'depends' => 'yii\web\YiiAsset' 
] );

$this->registerCssFile ( yii\helpers\Url::base () . '/css/typetree.css', [ 
		'depends' => 'yii\web\YiiAsset' 
] );

?>

<script type="text/javascript">
var baserurl = "";
var openUrl  = "<?= Url::to(['newstype/open']) ?>";
//var zNodes = new Array();
var ptypecreate = false; //新增
var ptypeupdate = false; //更新
var ptypedelete = false; //删除

var zNodes = JSON.parse('<?= \merchant\modules\item\services\ItemCategoryService::treeInit($item_id)

    /*
     *
     * 初始化分类数的数据
     * @param null $item_id
     * @return string
    public static function treeInit($item_id = null){
    $list = MeCategory::find()->where(['sw'=>1,'is_total'=>0,'del_flag'=>0])->asArray()->all();

    $cmp_arr = [];
    if ($item_id) {
        //获取商品的mcid 组
        $cmp_arr = MeCategoryItem::find()->where(['item_id'=>$item_id])->select('mcid')->column();
    }

    $data = [];
    foreach ($list as $item) {
        if (in_array($item['mcid'],$cmp_arr)) {
            $checked = 'true';
        } else {
            $checked = 'false';
        }
        $data[] = [
            'id' => $item['mcid'],
            'pId' => $item['pid'],
            'name' => $item['name'],
            'path' => $item['server_type'],
            'open' => 'false',
            'checked' => $checked,
        ];
    }
    return json_encode($data);
}

    */


    ?>');

</script>



<ul id="tree" class="ztree"></ul>