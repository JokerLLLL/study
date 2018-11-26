<?php
/**
 * Created by PhpStorm.
 * User: jokerl
 * Date: 2018/11/1
 * Time: 17:16
 */

namespace backend\components;


class TimeHelper
{

        /** 获取开始时间 到结束时间的 中文汉子显示
         * @param $start_time
         * @param null $end_time
         * @return string
         */
       public static function getIntervalTime($start_time,$end_time = null)
       {
            if(!$end_time) {
                $end_time = date('Y-m-d H:i:s');
            }
            $start_time = strtotime($start_time);
            $end_time = strtotime($end_time);

           $time_diff = $end_time - $start_time; //秒数

           //天
           $days = intval($time_diff/86400);

           // 时
           $left_day = $time_diff % 86400;
           $hours = intval($left_day/3600);

           // 分
           $left_hour = $left_day % 3600;
           $mins = intval($left_hour/60);

           // 秒
           $secs = $left_hour % 60;

           $days <= 0  &&  $days = 0;
           $hours <= 0 &&  $hours = 0;
           $mins <= 0  &&  $mins = 0;

           if($days == 0 && $hours == 0){
               $time_str = $mins.'分钟';
           }else if($days == 0){
               $time_str = $hours.'小时'.$mins.'分钟';
           }else{
               $time_str = $days.'天'.$hours.'小时'.$mins.'分钟';
           }
           return $time_str;
       }


    /** 连个时间差值
     * @param $start_time
     * @param $end_time
     * @param string $flag
     * @return string
     * @throws \Exception
     */
       public static function getDiffTime($start_time,$end_time = null,$flag = 'S')
       {
            if(!$end_time) {
               $end_time = date('Y-m-d H:i:s');
            }
            $start_time = strtotime($start_time);
            $end_time = strtotime($end_time);
            $diff = $end_time - $start_time;
            switch ($flag) {
                case 'S':
                    $format = strval($diff);
                    break;
                case 'I':
                    $format = bcdiv($diff,60,2);
                    break;
                case 'H':
                    $format = bcdiv($diff,60*60,2);
                    break;
                case 'D':
                    $format = bcdiv($diff,60*60*24,2);
                    break;
                default:
                    throw  new \Exception('错误时间格式类型');
                    break;
            }
            return $format;
       }

        /*
         * 判断时间是否在多少秒前
         */
        public static function getBoolBeforeSecond($time,$second,$equal = false)
        {
            $time = strtotime($time);
            if($equal) {
                return boolval($time <= (time() - $second));
            }
            return boolval($time < (time() - $second));
        }

    /** 获取昨天
     * @param string $format
     * @return false|string
     */
       public static function getYesterday($format = 'Y-m-d H:i:s')
       {
            return date($format,time() - 24*60*60);
       }


    /** 获取明天
     * @param string $format
     * @return false|string
     */
       public static function getTomorrow($format = 'Y-m-d H:i:s')
       {
           return date($format,time() + 24*60*60);
       }


    /** 从描述中获取时间
     * @param $desc
     * @param string $format
     * @return false|string
     * e.g: self::strToTime('-1 days'); //'last day of -1 month' // '-1 day'
     */
       public static function strToTime($desc,$format = 'Y-m-d H:i:s')
       {
            return date($format,strtotime($desc));
       }


    /** 获取两时间的日期列表
     * @param $start_time
     * @param $end_time
     * @return array
     */
       public static function listDates($start_time,$end_time)
       {
           $list = [];
           $dt_start = strtotime($start_time);
           $dt_end = strtotime($end_time);
           while ($dt_start <= $dt_end){
               $list[] = date('Y-m-d',$dt_start);
               $dt_start = strtotime('+1 day',$dt_start);
           }
           return $list;
       }


    /**
     * 获取下个星期的某一天
     * @param Integer $offset 偏移值，比如 1 即 星期一 default 0
     * @param String $formatStr 格式化字符串 default 'Y-m-d H:i:s'
     * @return String
     * @throws
     */
    public function getNextWeekFirstDay($offset = 0, $formatStr = 'Y-m-d H:i:s'){
        $currentWeekNum = date('w');
        $dataTime = new \DateTime(date('Y-m-d H:i:s',time()));
        $dataInterval = new \DateInterval('P1W');
        return $dataTime->add($dataInterval)
            ->sub(new \DateInterval('P' . $currentWeekNum . 'D'))
            ->add(new \DateInterval('P' . $offset . 'D'))
            ->format($formatStr);
    }
    /**
     * 获取上个星期的某一天
     * @param Integer $offset 偏移值，比如 1 即 星期一 default 0
     * @param String $formatStr 格式化字符串 default 'Y-m-d H:i:s'
     * @return String
     * @throws
     */
    public function getLastWeekFirstDay($offset = 0, $formatStr = 'Y-m-d H:i:s'){
        $currentWeekNum = date('w');
        $dataTime = new \DateTime(date('Y-m-d H:i:s',time()));
        $dataInterval = new \DateInterval('P1W');
        return $dataTime->sub($dataInterval)
            ->sub(new \DateInterval('P' . $currentWeekNum . 'D'))
            ->add(new \DateInterval('P' . $offset . 'D'))
            ->format($formatStr);
    }


}