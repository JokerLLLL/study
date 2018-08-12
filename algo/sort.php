<?php
/**
 * Created by PhpStorm.
 * User: JokerL
 * Date: 2018/8/10
 * Time: 0:09
 */





class Sort{

    /** 简单排序
     * @param $range
     * @return mixed
     */
    public function simpleSort(array &$range)
    {
        $count = count($range);
        for ($i=0;$i<$count;$i++) {
            for ($j=$i+1;$j<$count;$j++) {
                if($range[$i] > $range[$j]) {
                    $tmp = $range[$i];
                    $range[$i] = $range[$j];
                    $range[$j] = $tmp;
                }
            }
        }
        return $range;
    }

    /** 冒泡排序
     * @param array $range
     * @return array
     */
    public function bubbleSort(array &$range)
    {
        $length = count($range);
        for($i = 0;$i < $length - 1;$i ++){
            //从后往前逐层上浮小的元素
            for($j = $length - 2;$j >= $i;$j --){
                //两两比较相邻记录
                if($range[$j] > $range[$j + 1]){
                    $temp = $range[$j];
                    $range[$j] = $range[$j + 1];
                    $range[$j + 1] = $temp;
                }
            }
        }
        return $range;
    }


    /** 插入排序
     * @param array $range
     * @return array
     */
    public function insertSort(array &$range)
    {
        $count  = count($range);
        for($i = 1;$i < $count;$i ++) {
            //提前得到
            $tmp = $range[$i];
            for($j = $i;$j > 0 && $range[$j-1] > $tmp;$j --) {
                $range[$j] = $range[$j-1];
            }
            $range[$j] = $tmp;
        }
        return $range;
    }


    /** 希尔排序
     * @param array $range
     * @return array
     */
    public function shellSort(array &$range)
    {
        $count = count($range);
        $inc = $count;
        do{
            $inc = ceil($inc/2);
            for($i = $inc;$i < $count;$i++) {
                $tmp = $range[$i]; //考察元素 哨兵
                for($j = $i - $inc;$j >= 0 && $range[$j] > $range[$j + $inc] ; $j -= $inc) {
                    $range[$j + $inc] = $range[$j];
                }
                $range[$j + $inc] = $tmp;
            }

        }while($inc > 1);
        return $range;
    }


    /** 归并排序 顺序
     * @param $range
     */
    public function mergeSortL(&$range)
    {
        $this->mergeSort($range,0,count($range)-1);
    }

    /** 归并排序 逆序
     * @param $range
     */
    public function mergeSortR(&$range)
    {
        $count = count($range);
        //指定步长
        for($sz = 1; $sz<=$count-1; $sz += $sz) {
            //循环进行 合并 (条件 $i+$sz-1 < $count-1) 以及 $r 大于count-1 就取count-1
            for($i =0;$i + $sz-1 < $count-1;$i += 2*$sz) {
                //合并 [$i,$i+$sz-1] [$i+$z,$i+2*$sz-1] 进行合并
                //合并前判断是否已经有序
                if($range[$i+$sz-1] > $range[$i+$sz]) {
                    $this->doMerge($range,$i,$i+$sz-1,min($i+2*$sz-1,$count-1));
                }
            }
        }
    }


    //递归排序 对arr [l...r]的范围进行排序
    public function mergeSort(&$array,$l,$r)
    {
        if($l >= $r) {
            return;
        }
        $mid = floor(($l + $r)/2); //取整 配合mid + 1;
        $this->mergeSort($array,$l,$mid);
        $this->mergeSort($array,$mid+1,$r);
        //优化 如果 $mid 和 $mid+1 的元素对吧 说明有序 不用doMerger
        if($array[$mid] > $array[$mid+1]) {
            $this->doMerge($array,$l,$mid,$r);
        }
    }

    //将 array [l...mid] 和 [mid...r] 进行合并 0 0 1
    //前提 前段 和 后段 都是同顺的
    public function doMerge(&$array,$l,$mid,$r)
    {
        //截取一段用来排序的 数组
        $tmp_array = [];
        for($i = $l;$i <= $r;$i ++) {
            $tmp_array[$i-$l] = $array[$i];
        }
        $i = $l;           //前半段数组位置
        $j = $mid + 1;     //后半段数组位置
        //$k 表示 array当前要填写的位置
        for($k = $l;$k <= $r;$k ++) {
            if($i > $mid) { //如果 $i没有了 说明剩后半段数组了
                $array[$k] = $tmp_array[$j-$l];
                $j ++;
            }elseif ($j > $r) {
                $array[$k] = $tmp_array[$i-$l];
                $i ++;
            }elseif($tmp_array[$i-$l] < $tmp_array[$j-$l]) {
                $array[$k] = $tmp_array[$i-$l];
                $i ++;
            }else{
                $array[$k] = $tmp_array[$j-$l];
                $j ++;
            }
        }
    }


}