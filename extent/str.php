<?php
/**
 * 安全处理字符串，html PHP 标签类 【secure】
 * @author    sam@imccc.net
 * @since     2018-02-05 06:14:55
 */

class str
{
    /**
     * 处理字符串信息
     */
    public static function hStr($string)
    {
        if (isset($string) && !empty($string)) {
            return addslashes(strip_tags($string));
        } else {
            return "";
        }
    }

    /**
     * 转议html实体
     */
    public static function enHtml($html)
    {
        if (isset($html) && !empty($html)) {
            return htmlentities($html);
        } else {
            return "";
        }
    }

    /**
     * 解析html实体
     */
    public static function deHtml($str)
    {
        if (isset($str) && !empty($str)) {
            return html_entity_decode($str);
        } else {
            return "";
        }
    }

    /**
     * 字符串截取，支持中文和其他编码
     */
    public function msubstr($str, $start = 0, $length, $charset = "utf-8", $suffix = true)
    {
        if (function_exists("mb_substr")) {
            $slice = mb_substr($str, $start, $length, $charset);
        } elseif (function_exists('iconv_substr')) {
            $slice = iconv_substr($str, $start, $length, $charset);
            if (false === $slice) {
                $slice = '';
            }
        } else {
            $re['utf-8']  = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
            $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
            $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
            $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
            preg_match_all($re[$charset], $str, $match);
            $slice = join("", array_slice($match[0], $start, $length));
        }
        return $suffix ? $slice . '...' : $slice;
    }

}