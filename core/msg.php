<?php
/**
 * Msg处理类   msg
 * @author    sam@imccc.net
 * @since    2018-10-03 00:31:51
 */
class msg
{
    /**
     * 控制式调用信息
     */
    public static function show($code = 0, $var = null, $end = false, $mode = 'page')
    {
        $_lmsg = (new language)->local();
        switch ($mode) {
            case 'api':
                api::put($code, $var);
                break;

            case 'page':
            default:
                $str = "<span style='color:red'>" . $_lmsg[$code] . " - [" . $var . "] </span>";
                echo $str . "<br />";
                break;
        }
        unset($_lmsg);

        if ($end) {
            die;
        }
    }

}
