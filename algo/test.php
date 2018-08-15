<?php
/**
 * Created by PhpStorm.
 * User: JokerL
 * Date: 2018/8/13
 * Time: 1:07
 */

require_once './sort.php';
$sort = new Sort();

function doExam($callBack,&$array) {
    echo 'callBack:'.$callBack[1];
    $start_time = microtime(true);
    call_user_func($callBack,$array);
    $end_time = microtime(true);
    echo '--time:'.($end_time - $start_time)."\n";
}
$range = range(0,100,2);
shuffle($range);
$range1 = $range;
$range2 = $range;
$range3 = $range;
$range4 = $range;
$range5 = $range;
$range6 = $range;

//doExam([$sort,'simpleSort'],$range1);
//doExam([$sort,'insertSort'],$range2);
doExam([$sort,'shellSort'],$range3);
doExam([$sort,'mergeSortL'],$range4);
doExam([$sort,'mergeSortR'],$range5);
doExam([$sort,'quickSort2'],$range6);
var_dump($range1,$range2,$range3,$range4,$range6);
