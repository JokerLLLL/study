```php

<div class="form-group">
    <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
    <?= Html::submitInput(Yii::t('app', '导出Excel'), ['class' => 'btn btn-primary','name'=>'PriceRefundSearch[excel]']) ?> 按钮excel命名

<?php

public function search()
{
    //searchModel层判断是否excel导出
    if($this->excel) {
        $this->outExcel($query);
    }

}



/**数据整理
 * @param $query
 */
public function outExcel($query)
{
    $data = $query->asArray()->all();
    $title = ['渠道','校区','姓名','账户余额'];
    $i = 0;
    $array = [];
    foreach ($data as $v) {
        @$array[$i][] = $v['school']['shop']['name'];
        @$array[$i][] = $v['school']['name'];
        @$array[$i][] = $v['nickname'];
        @$array[$i][] = $v['account'];
        $i++;
    }
    Bases::OutExcel($title,$array);
}


/** 数据导出
 * @param $row
 * @param $value_arr
 */
public static function OutExcel($row,$value_arr)
{
    $objPHPExcel = new \PHPExcel();
//        $excelWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
//        $excelWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
    ######################保存文件###############
    //$excelWriter->save(\Yii::getAlias('@webroot/ceshi')."/1271.xlsx");
    //return 'success';
    ##################输出浏览器####################
//        $objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
//        header("Pragma: public");
//        header("Expires: 0");
//        header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
//        header("Content-Type:application/force-download");
//        header("Content-Type:application/vnd.ms-execl");
//        header("Content-Type:application/octet-stream");
//        header("Content-Type:application/download");;
//        header('Content-Disposition:attachment;filename="resume.xls"');
//        header("Content-Transfer-Encoding:binary");
//        $objWriter->save('php://output');
    ##################设置属性##################################
//       $properties = $objPHPExcel->getProperties();
//       $properties->setCreator('test creator');
//       $properties->setLastModifiedBy('ssd');
//       $properties->setTitle('设置标题');
//       $properties->setSubject('设置题目');
//       $properties->setDescription('描述');
//       $properties->setKeywords('关键字。。');
////        ##################设置当前sheet###############
//       $objPHPExcel->setActiveSheetIndex(0);
//       $objPHPExcel->getActiveSheet()->setCellValue('A1','我我我');
//       $objPHPExcel->getActiveSheet()->setCellValue('A2','12');
//       $objPHPExcel->getActiveSheet()->setCellValue('A3',true);
//       $objPHPExcel->getActiveSheet()->setCellValue('C5','=SUM(C2:C4)');
//        $objPHPExcel->getActiveSheet()->setCellValue('B8','=MIN(52:C5)');
//        $objPHPExcel->getActiveSheet()->mergeCells('A18:E22'); //合并单元格 无效
//        $objPHPExcel->getActiveSheet()->unmergeCells('A28:B28');//分离
//       $row = ['标题1','标题2','标题3'];
//       $value_arr = [
//           ['test1','test11','test111'],
//           ['test2','test22','test222'],
//           ['test3','test33','test333'],
//       ];
    $count = count($value_arr); //行数
    $count2 = count($row);  //列数
    $nowSheet = $objPHPExcel->getActiveSheet();
//    $nowSheet->setCellValue('A1','id');
//    $nowSheet->setCellValue('B1', 'name');

    //写入表头
    for ($j = 0; $j < $count2; $j++) {
        $x = \PHPExcel_Cell::stringFromColumnIndex($j); //列名字 把数字变成对应的ABCD.....的坐标
        $nowSheet->setCellValue($x.'1', $row[$j]);
    }

    //内容写入
    for ($i = 2; $i < $count+2; $i++) {
        for ($j = 0; $j < $count2; $j++) {
            $x = \PHPExcel_Cell::stringFromColumnIndex($j); //列名字 把数字变成对应的ABCD.....的坐标
            $nowSheet->setCellValue($x.$i, $value_arr[$i-2][$j]);
        }
    }

    $objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
//       $objWriter2 = new \PHPExcel_Writer_Excel2007($objPHPExcel);
    $filename = date('Y-d-mHis').rand(1000,9999);
//        header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
    header("Content-Type:application/force-download");
    header("Content-Type:application/vnd.ms-execl");
    header("Content-Type:application/octet-stream");
    header("Content-Type:application/download");;
    header('Content-Disposition:attachment;filename="'.$filename.'.xls"');
    header("Content-Transfer-Encoding:binary");
    $objWriter->save('php://output');
    exit();
}
