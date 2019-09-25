<?php

/**
 * 数据模型基类  model 所有数据请求都基于本基类
 * @author    imccc
 * @since    2018-10-03 00:31:51
 */
class model
{
    protected $_db;
    protected $_model;
    protected $_table;
    protected $_datas;

    public function __construct()
    {
        $this->_db = cfg::v("db")[cfg::v("db.model")];
        $this->_model = new medoo($this->_db);
        $this->_datas = [];
    }

    /**
     * 返回数据
     */
    public function recode($data = [], $code = 200)
    {
        if(empty($data)){
            $code=100;
        }
        return ['code' => $code, 'data' => $data];
    }

    /**
     * 保存数据
     */
    public function saveValue($table, $arr)
    {
        if ($this->_model->has($table, $arr)) {
            $db = $this->_model->update($table, $arr);
        } else {
            $db = $this->_model->instret($table, $arr);
        }
    }

    /**
     * 消费
     */
    public function __destruct()
    {
        debug::sql($this->_model->log());
        unset($this->_datas);
    }
}
