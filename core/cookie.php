<?php
/**
 * Cookie的设置、读取、更新、删除
 */
class cookie{
    static private $_instance = null;
    private $expire= 0;
    private $path = '';
    private $domain = '';
    private $secure = false;
    private $httponly = false;

    /**
     * 构造函数完成Cookie参数初始化工作
     * @param array $options [Cookie相关选项]
     */
    private function __construct(array $options=[]){
        $this->setOptions($options);
    }
    /**
     * 设置相关选项
     * @param array $options [Cookie相关选项]
     */
    private function setOptions(array $options=[]){
        if(isset($option['expire'])){
            $this->expire = (int)$options['expire'];
        }
        if(isset($options['path'])){
            $this->path = $options['path'];
        }
        if(isset($options['domain'])){
            $this->domain = $options['domain'];
        }
        if(isset($options['secure'])){
            $this->secure = (bool)$options['secure'];
        }
        if(isset($options['httponly'])){
            $this->httponly = (bool)$options['httponly'];
        }
        return $this;
    }

    /**
     *单例模式
     * @param [array] $options [Cookie相关选项]
     * @param [object]          [对象实例]
     */
    public static function getInstance(array $options=[]){
        if (!cfg::v('cookie.setcookie')){
            msg::show(600);
        }
        if(is_null(self::$_instance)){
            $class = __CLASS__;
            self::$_instance = new $class($options);
        }
        return self::$_instance;
    }
    /**
     * [设置Cookie]
     * @param string $name     Cookiede的名称
     * @param mixed  $value    Cookiede的值
     * @param array  $options  Cookie相关选项
     */
    public function set($name,$value,array $options=[]){
        if(is_array($options)&&count($options)>0){
            $this->setOptions($options);
        }
        if(is_array($value)||is_object($value)){
            $value = json_encode($value);
        }
        setcookie($name,$value,$this->expire,$this->path,$this->domain,$this->secure,$this->httponly);
    }

    /**
     * 得到指定的cookie
     * @param  string $name Cookie名称
     * @return mixed       返回null或者对象或者标量
     */
    public function get($name){
        if(isset($_COOKIE[$name])){
            substr($_COOKIE[$name],0,1)=='{'?json_decode($_COOKIE[$name]):$_COOKIE[$name];
        }else{
            return null;
        }
    }

    /**
     * 删除指定cookie
     * @param string $name Cookie名称
     * @param array $options 相关选项
     */
    public function delete(string $name,array $options=[]){
        if(is_array($options) && count($options) > 0){
            $this->setOptions($options);
        }
        if(isset($_COOKIE[$name])){
            setcookie($name,'',time()-1,$this->path,$this->domain,$this->secure,$this->httponly);
            unset($_COOKIE[$name]);
        }
    }

    /**
     * 删除所有cookie
     */
    public function deleteAll(array $options=[]){
        if(is_array($options) && count($options) > 0){
            $this->setOptions($options);
        }
        if(!empty($_COOKIE)){
            foreach($_COOKIE as $name=>$value){
                setcookie($name,'',time()-1,$this->path,$this->domain,$this->secure,$this->httponly);
                unset($_COOKIE[$name]);
            }
        }
    }
}