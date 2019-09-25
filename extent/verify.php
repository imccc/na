<?php
/**
 * 公用函数库，验证类 【verify】
 * @author    sam@imccc.net
 * @since     2018-02-05 05:25:13
 */
class verify
{
    /**
     * 判断是否是ajax请求
     */
    public static function isAjax()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 正则邮箱
     */
    public static function isEmail($string)
    {
        $resultStr = preg_match("/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i", $string);
        if (intval($resultStr) == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 正则验证身份证/(^([d]{15}|[d]{18}|[d]{17}x)$)/
     */
    public static function isIdCard($string)
    {
        $resultStr = preg_match("/(^([d]{15}|[d]{18}|[d]{17}x)$)/", $string);
        if (intval($resultStr) == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 正则手机号 /^((1[3,5,7,8][0-9])|(14[5,7])|(17[0,6,7,8]))\d{8}$/
     */
    public static function isPhone($string)
    {
        $resultStr = preg_match("/^((1[3,5,7,8][0-9])|(14[5,7])|(17[0,6,7,8]))\d{8}$/", $string);
        if (intval($resultStr) == 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 校验日期格式是否正确
     * @param string $date :日期
     * @param string $formats : 需要检验的格式数组
     * @return boolean
     */
    public static function isDate($date, $formats = ['Y-m-d', 'Y/m/d'])
    {
        $timestamp = strtotime($date);
        if (!$timestamp) {
            return false;
        }
        foreach ($formats as $format) {
            if (date($format, $timestamp) == $date) {
                return true;
            }
        }
        return false;
    }

    /**
     * 检查是否是json
     * @param string $string : 需要检验的字符
     * @return boolean
     */
    public static function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

}
