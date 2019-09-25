<?php
class view
{
    protected $datas = [];
    protected $_module;
    protected $_controller;

    public function __construct($module, $controller, $action)
    {
        $this->_module = $module;
        $this->_controller = $controller;
        $this->_action = $action;
    }

    /** 分配变量 **/
    public function assign($name, $value)
    {
        $this->datas[$name] = $value;
    }

    /** 渲染显示 **/
    public function render()
    {
        $mdir = str_replace(cfg::v("def.controller_fix"), "", $this->_controller);
        extract($this->datas);

        switch (cfg::v('put.' . $this->_module)) {
            case 'page':
                // header::output("html");
                $defaultHeader = APP_PATH . DS . $this->_module . DS . "include" . DS . "header" . EXT;
                $defaultFooter = APP_PATH . DS . $this->_module . DS . "include" . DS . "footer" . EXT;
                $defaultNav = APP_PATH . DS . $this->_module . DS . "include" . DS . "nav" . EXT;

                $actionHeader = APP_PATH . DS . $this->_module . DS . "view" . DS . $mdir . DS . 'include' . DS . $this->_action . ".header" . EXT;
                $actionFooter = APP_PATH . DS . $this->_module . DS . "view" . DS . $mdir . DS . 'include' . DS . $this->_action . ".footer" . EXT;
                $actionNav = APP_PATH . DS . $this->_module . DS . "view" . DS . $mdir . DS . 'include' . DS . $this->_action . ".nav" . EXT;

                // 页头文件
                if (file_exists($actionHeader)) {
                    require_once $actionHeader;
                } else if (file_exists($defaultHeader)) {
                    require_once $defaultHeader;
                }

                // 导航文件
                if (cfg::v("view.nav")) {
                    if (file_exists($actionNav)) {
                        require_once $actionNav;
                    } else if (file_exists($defaultNav)) {
                        require_once $defaultNav;
                    }
                }

                // 页内容文件
                $view_file = APP_PATH . DS . $this->_module . DS . 'view' . DS . $this->_controller . DS . $this->_action . cfg::v("def.view_ext");
                if (file_exists($view_file)) {
                    require_once $view_file;
                } else {
                    msg::show(9, $view_file);
                }

                // 页脚文件
                if (file_exists($actionFooter)) {
                    require_once $actionFooter;
                } else if (file_exists($defaultFooter)) {
                    require_once $defaultFooter;
                }
                break;

            case 'api':
                $code = $code ?: 0;
                $data = $data ?: "";
                api::put($code, $data);
                break;

            default:
                msg::show(5, cfg::v('sys.type'));
                break;
        }

    }

    public function __destruct()
    {
    }
}
