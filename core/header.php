<?php
/**
 * 页头输出类  header
 * @author    imccc
 * @since     2018-10-03 00:31:51
 */
class header
{
    /**
     * 转向
     */
    public static function url($url)
    {
        if (preg_match("/^(http:\/\/|https:\/\/).*$/", $url)) {
            header("Location: " . $url);
        } else {
            header("Location: http://" . $_SERVER['SERVER_NAME'] . $url);
        }
    }
    
    /**
     * 输出页头 并控制是否过期
     * @param $type 头类型 如 xml json html txt等
     */
    public static function output($type = "html")
    {
        header("Content-Type: " . cfg::v("type." . $type) . "; charset= " . cfg::v("sys.char-set"));
        
        if (cfg::v("sys.no_cache")){
            header("Expires: Mon, 5 Dec 1975 00:00:00 GMT");
            header("Cache-Control:no-cache");
            header("Pragma:no-cache");
        }
    }

}
