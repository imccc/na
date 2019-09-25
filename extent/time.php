<?php
/**
 * @author    Simple
 * @link      simple@bigcapital.co
 * @copyright BCC.INC
 * @version   1.0
 * @license   MIT
 * @since     2018-02-08 07:58:11
 */

class time
{

//时间格式化1
    public function formatTime($time)
    {
        $now_time = time();
        $t        = $now_time - $time;
        $mon      = (int) ($t / (86400 * 30));
        if ($mon >= 1) {
            return '一个月前';
        }
        $day = (int) ($t / 86400);
        if ($day >= 1) {
            return $day . '天前';
        }
        $h = (int) ($t / 3600);
        if ($h >= 1) {
            return $h . '小时前';
        }
        $min = (int) ($t / 60);
        if ($min >= 1) {
            return $min . '分钟前';
        }
        return '刚刚';
    }

//时间格式化2
    public function pincheTime($time)
    {
        $today = strtotime(date('Y-m-d')); //今天零点
        $here  = (int) (($time - $today) / 86400);
        if (1 == $here) {
            return '明天';
        }
        if (2 == $here) {
            return '后天';
        }
        if ($here >= 3 && $here < 7) {
            return $here . '天后';
        }
        if ($here >= 7 && $here < 30) {
            return '一周后';
        }
        if ($here >= 30 && $here < 365) {
            return '一个月后';
        }
        if ($here >= 365) {
            $r = (int) ($here / 365) . '年后';
            return $r;
        }
        return '今天';
    }

}