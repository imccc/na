<?php

/**
 * Session处理类 session
 * @author    Samlu
 * @since    2018-10-03 00:31:51
 */
class session
{
    /**
     * 启用Session
     */
    public static function start()
    {
        session_start();
    }

    /**
     * 取得Session ID
     */
    public static function id()
    {
        return session_id();
    }

    /**
     * 设置Session Value
     * @param $arr : 赋值数组
     */
    public static function set($name, $value)
    {
        $pre = cfg::v("session.prefix");
        $_SESSION[$pre . $name] = $value;
    }

    public static function setarr($arr = [])
    {
        $pre = cfg::v("session.prefix");
        if (array_count_values($arr) > 0) {
            foreach ($arr as $key => $value) {
                $_SESSION[$pre . $key] = $value;
            }
        }
    }

    /**
     * 读取Session Value
     * @param $arr : 字段名 返回 数组
     */
    public static function get($name)
    {
        $pre = cfg::v("session.prefix");
        if (isset($_SESSION[$pre . $name])) {
            return $_SESSION[$pre . $name];
        } else {
            return false;
        }
    }

    public static function getarr($arr = [])
    {
        $pre = cfg::v("session.prefix");
        if (array_count_values($arr) > 0) {
            foreach ($arr as $key => $value) {
                return $_SESSION[$pre . $key];
            }
        } else {
            return false;
        }
    }

    /**
     * 删除Session Value
     * @param $name : 字段名
     */
    public static function del($name)
    {
        unset($_SESSION[$name]);
    }

    public static function delarr($arr = [])
    {
        $pre = cfg::v("session.prefix");
        if (array_count_values($arr) > 0) {
            foreach ($arr as $key => $value) {
                unset($_SESSION[$pre . $key]);
            }
        } else {
            return false;
        }
    }

    /**
     * 销毁Session
     */
    public static function destroy()
    {
        unset($_SESSION);
        session_destroy();
    }

}