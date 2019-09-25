<?php

/**
 * 调度类   dispatcher
 * @author imccc
 * @since    2018-10-03 00:31:51
 */

class dispatcher
{
    public static function dispatch($router)
    {
        $m = $router[M] ?: cfg::v("def.module");
        $c = $router[C] ?: cfg::v("def.controller");
        $a = $router[A] ?: cfg::v("def.action");
        $nc = $c . CONTROLLER_FIX;

        if (array_key_exists($m, cfg::v("put"))) {

            set_include_path(APP_PATH . DS . $m . DS . "controller"
                . PS . APP_PATH . DS . $m . DS . "model"
                . PS . APP_PATH . DS . $m . DS . "view"
                . PS . get_include_path());

            if(!class_exists($nc)){
                msg::show(2, $c, true, cfg::v('put.' . $m));
            }
            if (!method_exists($nc, $a)) {
                msg::show(3, $a, true, cfg::v('put.' . $m));
            }

            debug::info($router["param"]);
            $dispatch = new $nc($m, $c, $a);
            call_user_func_array(array($dispatch, $a), $router["param"]);
        } else {
            msg::show(4, $m, true, cfg::v('put.' . $m));
        }
    }
}
