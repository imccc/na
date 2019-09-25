<?php
/**
 * @author    imccc
 * @since     2018-02-06 13:15:42
 */
class rand
{
    /*
     * 私有处理随机数的内置参数
     * array 随机数数组/param 随机数长度
     * 返回一个随机数
     */
    private static function random($array, $param)
    {
        $randArray = $array;
        $randCount = count($randArray);
        $num       = intval($param);
        $resultStr = "";
        for ($i = 0; $i < $num; $i++) {
            $resultStr .= $randArray[rand(0, intval($randCount) - 1)];
        }
        return $resultStr;
    }

    /**
     * 随机数（数字类型）
     */
    public static function randnum($param = 8)
    {
        $randArray = str_split("1234567890");
        $resultStr = self::random($randArray, $param);
        return $resultStr;
    }

    /**
     * 随机数（混合类型） - 无0
     */
    public static function randStr($param = 8, $capslock = false)
    {
        $randArray = str_split("abcdefghijklmnopqrstuvwxyz123456789ABCDEFGHIGKLMNOPQRSTUVWXYZ");
        $resultStr = self::random($randArray, $param);
        if ($capslock) {
            return strtoupper($resultStr);
        } else {
            return $resultStr;
        }
    }
}