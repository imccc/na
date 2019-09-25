<?php
/**
 * 配置类    cfg
 * @author  imccc
 * @since    2018-10-03 00:31:51
 */
class cfg
{
    /**
     * 载入配置文件
     * @param $fie 文件名由static::v传递过来
     */

    private static function load($file)
    {
        $f = stream_resolve_include_path(CONFIG_DIR_NAME . DS . CFG_PREFIX . $file . EXT);
        if ($f !== false) {
            return require $f;
        } else {
            msg::show(1, $file, true);
        }
    }

    /**
     * 读取配置值
     */
    public static function v($var = null)
    {
        //分解字串
        $tmp = explode('.', $var);

        //计算字串长度，并且指定执行类型
        $type = count($tmp);

        //配置文件名
        $file = $tmp[0];

        //加载配置
        $cfgs = static::load($file);

        switch ($type) {
            //返回文件整个数组
            case 1:
                return $cfgs;
                break;

            case 2:
                $k1 = $tmp[1]; //键值
                if (array_key_exists($k1, $cfgs)) {
                    return $cfgs[$k1];
                } else {
                    msg::show(1, $var);
                }
                break;

            case 3:
                $k1 = $tmp[1];
                $k2 = $tmp[2];
                if (array_key_exists($k2, $cfgs[$k1])) {
                    return $cfgs[$k1][$k2];
                } else {
                    msg::show(1, $var);
                }
                break;

            default:
                msg::show(7, $var, true);
                break;
        }
        unset($cfgs);
    }
}
