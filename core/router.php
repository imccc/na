<?php
/**
 * 路由类      router 
 * @author    samlu
 * @since    2018-10-03 00:31:51
 */
class router
{
    public $url_type;
    public $var_module;
    public $var_controller;
    public $var_action;

    /**
     * 初始化方法
     */
    public function __construct()
    {
        $this->url_type = U;
        $this->var_module = M;
        $this->var_controller = C;
        $this->var_action = A;
        $this->makeUrl();
    }
    /**
     * 获取url打包参数
     * @return type
     */
    private function makeUrl()
    {
        switch ($this->url_type) {
            //动态url传参 模式
            case 0:
                dispatcher::dispatch($this->getUrl());
                break;
            //pathinfo 模式
            case 1:
                dispatcher::dispatch($this->getPathinfo());
                break;
        }
    }

    /**
     * 获取参数通过url传参模式
     */
    private function getUrl()
    {
        $arr = empty($_SERVER['QUERY_STRING']) ? array() : explode('&', $_SERVER['QUERY_STRING']);
        $data = [];        

        if (!empty($arr)) {
            $tmp = [];
            $part = [];

            foreach ($arr as $v) {
                $tmp = explode('=', $v);
                $tmp[1] = isset($tmp[1]) ? trim($tmp[1]) : '';
                $part[$tmp[0]] = $tmp[1];
            }

            if (isset($part[$this->var_module])) {
                $data[$this->var_module] = $part[$this->var_module];
                unset($part[$this->var_module]);
            }

            if (isset($part[$this->var_controller])) {
                $data[$this->var_controller] = $part[$this->var_controller];
                unset($part[$this->var_controller]);
            }

            if (isset($part[$this->var_action])) {
                $data[$this->var_action] = $part[$this->var_action];
                unset($part[$this->var_action]);
            }

            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':
                    unset($_GET[$this->var_controller], $_GET[$this->var_action],$_GET[$this->var_module]);
                    $data["param"] = array_merge($part, $_GET);
                    unset($_GET);
                    break;

                case 'POST':
                    unset($_POST[$this->var_controller], $_POST[$this->var_action],$_GET[$this->var_module]);
                    $data["param"] = array_merge($part, $_POST);
                    unset($_POST);
                    break;
            }
            return $data;
        }
    }

    /**
     * 获取参数通过pathinfo模式
     */
    private function getPathinfo()
    {
        $part = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        $data = array([]);

        if (!empty($part)) {
            krsort($part);
            $data[$this->var_module]     = array_pop($part);
            $data[$this->var_controller] = array_pop($part);
            $data[$this->var_action]     = array_pop($part);
            ksort($part);

            $part = array_values($part);
            $tmp = array();

            if (count($part) > 0) {
                foreach ($part as $k => $v) {
                    if ($k % 2 == 0) {
                        $tmp[$v] = isset($part[$k + 1]) ? $part[$k + 1] : '';
                    }
                }
            }

            switch ($_SERVER['REQUEST_METHOD']) {
                case 'GET':
                    unset($_GET[$this->var_controller], $_GET[$this->var_action],$_GET[$this->var_module], $_GET["url"]);
                    $data["param"] = array_merge($tmp, $_GET);
                    unset($_GET);
                    break;

                case 'POST':
                    unset($_POST[$this->var_controller], $_POST[$this->var_action], $_GET[$this->var_module],$_POST["url"]);
                    $data["param"] = array_merge($tmp, $_POST);
                    unset($_POST);
                    break;
            }
        }
        return $data;
    }

}