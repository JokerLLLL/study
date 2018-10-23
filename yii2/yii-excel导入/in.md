```php

<?php

/** 批量导入数据
 * @return string|\yii\web\Response
 */
public function actionLeadExcel()
{
    //渲染视图
    $model = new SchoolRoom();
    if(!Yii::$app->request->isPost) {
        return $this->render('lead-excel', [
            'model' => $model,
        ]);
    }
    //上传数据处理
    if (empty($_FILES['file']['size']) || ($_FILES['file']['size'] == 0)) {
        return $this->redirect(['lead-excel']);
    }

    $post = Yii::$app->request->post();

    $namearr = [
        'floor'=> Yii::t('app', '楼层'),
        'room' => Yii::t('app', '房间号'),
    ];
    $filedata =  $this->picupload();
    $file_name = $filedata['path'];

}




    /** 取出数据
     * @param $file
     * @param array $columns
     * @throws \Exception
     * @return array
     */
    public static function OutData($file,$columns = [])
    {
        //表头判断
        $extension = pathinfo($file,PATHINFO_EXTENSION);
        if($extension == 'xls') {
            $readType = 'Excel5';
        }elseif($extension == 'xlsx'){
            $readType = 'Excel2007';
        }else{
            throw new \Exception('Excel格式错误');
        }

        $objReader = \PHPExcel_IOFactory::createReader($readType);
        $objPHPExcel = $objReader->load($file, $encode = 'utf-8');
        $sheet = $objPHPExcel->getSheet(0); //第一页有效


        $highestRow = $sheet->getHighestRow(); // 取得总行数
        //列数取到的是 字母 A B C ...进行转换
        $highestColumn = \PHPExcel_Cell::columnIndexFromString($sheet->getHighestColumn()); // 取得总列数

        //读取表头
        $title = [];
        for($l = 0;$l < $highestColumn;$l ++) {
            $x  = \PHPExcel_Cell::stringFromColumnIndex($l); //将 0=>A 1=>B ....
            $tmp = $objPHPExcel->getActiveSheet()->getCell($x.'1')->getValue();
            @$title[] = $tmp;
        }

        //数据读取 第二行开始读取数据
        $data = [];
        for($y = 2; $y <= $highestRow; $y ++) {
            //列读取数据
            for($l = 0;$l < $highestColumn;$l ++) {
                $x  = \PHPExcel_Cell::stringFromColumnIndex($l); //将 0=>A 1=>B ....
                $column = $title[$l];
                isset($columns[$l]) && $column = $columns[$l];
                //数据读取
                $data[$y-2][$column] = $objPHPExcel->getActiveSheet()->getCell($x.$y)->getValue();
            }
        }

        return ['title'=>$title,'data'=>$data];
    }
