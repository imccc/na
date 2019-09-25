<?php
/**
 * 控制器基类  controller 所有控制器类都要继承于本类
 * @author    sam@imccc.net
 * @since    2018-10-03 00:31:51
 */

class controller
{
    protected $_module;
    protected $_controller;
    protected $_action;
    protected $_view;

    // 构造函数，初始化属性，并实例化对应模型
    public function __construct($module, $controller, $action)
    {
        $this->_module = $module;
        $this->_controller = $controller;
        $this->_action = $action;
        $this->_view = new view($module, $controller, $action);
    }

    // 分配变量
    public function assign($name, $value)
    {
        $this->_view->assign($name, $value);
    }

    //是不是post请求
    public function getIsPostRequest()
    {
        return isset($_SERVER['REQUEST_METHOD']) && !strcasecmp($_SERVER['REQUEST_METHOD'], 'POST');
    }

    // 转换请求的json为数组
    public function j2a()
    {
        $json = file_get_contents("php://input");
        $arr = (array) json_decode($json, true);
        return $arr;
    }

    // nav
    public function nav()
    {
        if (cfg::v("view.nav")) {
            $d = CACHE_PATH . DS . 'data' . DS . 'nav.json';
            if (file_exists($d)) {
                $link = file_get_contents($d);
            } else {
                $link = "err";
            }
            return $link;
        }
    }

    // 签名认证
    /*----接收方待处理验证数据- start ----*/
    /**
     * 后台验证sign是否合法
     * @param [type] $secret [description]
     * @param [type] $data [description]
     * @return [type] [description]
     */
    public function verifySign($secret, $data)
    {
        // 验证参数中是否有签名
        if (!isset($data['sign']) || !$data['sign']) {
            msg::show(20);
        }
        if (!isset($data['timestamp']) || !$data['timestamp']) {
            msg::show(21);
        }
        // 验证请求， 10分钟失效
        if (time() - $data['timestamp'] > 600) {
            msg::show(22);
        }
        $sign = $data['sign'];
        unset($data['sign']);
        ksort($data);
        $params = http_build_query($data);
        // $secret是通过key在api的数据库中查询得到
        $sign2 = md5($params . $secret);
        if ($sign == $sign2) {
            msg::show(23);
        } else {
            msg::show(24);
        }
    }
    /*----接收方待处理验证数据- end ----*/

    // 渲染视图
    public function __destruct()
    {
        $this->_view->render();
    }

}
