<?php

class getinput
{
     // 转换请求的json为数组
     public static function j2a()
     {   
         $json = file_get_contents("php://input");
         
         if (self::is_json($json)){
             $arr = (array)json_decode($json, true);
         }else{
             parse_str($json,$arr);
         }
         return $arr;
     }

     // is json
    public static function is_json($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

}
