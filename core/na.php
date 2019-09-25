<?php
/**
 * 框架核心类 na.php
 * @author   sam@imccc.net
 * @since    2019-06-14 07:47:51
 */

class na
{
    /**
     * 执行程序
     */
    public function run()
    {
        $this->setpath();
        $this->autoload();
        $this->initialize();
        new router;
    }

    /**
     *  设置include路径
     */
    private function setpath()
    {
        set_include_path("."
            . PS . NA_PATH . DS . "core"
            . PS . NA_PATH . DS . "extent"
            . PS . NA_PATH . DS . "vendor"
            . PS . NA_PATH . DS . "vendor" . DS . "pay"
            . PS . LANGUAGE_PATH
        );
    }

    /**
     * 注册自动中载类
     */
    private function autoload()
    {
        spl_autoload_register(array(__CLASS__, "load"));
    }

    /**
     * 初始化
     */
    private function initialize()
    {
        //开启错误报告
        if (ERROR_REPOT) {
            error_reporting(E_ALL);
        } else {
            error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED);
        }

        // 开启自定义错误处理
        if (CUSTOM_HANDLE) {
            register_shutdown_function(array('handle', 'systemError'));
            set_exception_handler(array('handle', 'appException'));
            set_error_handler(array('handle','appError'));
        }
        session::start();
        date_default_timezone_set(cfg::v("sys.time_zone"));
    }

    /**
     * 自动加载类
     */
    private function load($class)
    {
        $f = stream_resolve_include_path($class . EXT);
        if (file_exists($f)) {
            require $f;
            clearstatcache();
        }
    }

}
