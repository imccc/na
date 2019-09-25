<?php
/**
 * 接口类 api
 * @author    sam@imccc.net
 * @since     2018-19-03 00:31:51
 */
class api
{
    /**
     * 用于返回指定数据格式的类
     * @param $code [int] 返回的状态码
     * @param $data [array] 需要返回的数据
     */
    public static function put($code = -1, $data = null)
    {
        //载入本地化语言文件
        $_lmsg = (new language)->local();
        //判断代码是滞存在，存在则执行操作
        if (array_key_exists($code, $_lmsg)) {
            $type = cfg::v("api.type");
            switch ($type) {
                case 'xml':
                    self::xml($code, $_lmsg[$code], $data);
                    break;
                case 'json':
                    self::json($code, $_lmsg[$code], $data);
                    break;
                default:
                    msg::show(5, cfg::v("api.type"), true);
                    break;
            }
        } else {
            //不存在则提示错误
            msg::show(8, $code, true);
        }
        unset($_lmsg);
    }

    /**
     * 生成json
     * @param $code [int] 返回的状态码
     * @param $message [string] 返回的状态码对应的提示消息 存在于语言文件中
     * @param $data [*] 返回的数据 支持 string array json
     */
    private static function json($code, $message, $data)
    {
        header::output("json"); //json

        $json = [
            "code" => $code,
            "message" => $message,
            "data" => $data,
        ];

        if (cfg::v('api.show')) {
            echo (json_encode($json, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        } else {
            return json_encode($json);
        }

    }

    /**
     * 生成xml
     * @param $code [int] 返回的状态码
     * @param $message [string] 返回的状态码对应的提示消息 存在于语言文件中
     * @param $data [*] 返回的数据 支持 string array json
     */
    private static function xml($code, $message, $data)
    {
        header::output("xml"); //xml

        $result = [
            "code" => $code,
            "message" => $message,
            "data" => $data,
        ];

        $xml = "<?xml version='1.0' encoding='UTF-8'?>" . PHP_EOL;
        $xml .= "<root>";
        $xml .= self::encodeXml($result);
        $xml .= "</root>";

        if (cfg::v('api.show') === true) {
            echo $xml;
        } else {
            return $xml;
        }
    }

    /**
     * data输出为xml
     * @param $data [array || object]
     */
    private static function encodeXml($data)
    {
        $attr = $xml = "";
        foreach ($data as $key => $value) {

            if (is_numeric($key)) {
                if (cfg::v('api.itemid')) {
                    $attr = " id='$key'";
                }
                $key = "item";
            }

            $xml .= "<{$key}{$attr}>";
            if (in_array($key, cfg::v("api.cdata"))) {
                $xml .= is_array($value) || is_object($value) ? self::encodeXml($value) : "<![CDATA[" . $value . "]]>";
            } else {
                $xml .= is_array($value) || is_object($value) ? self::encodeXml($value) : $value;
            }
            $xml .= "</$key>";

        }
        return $xml;
    }

}
