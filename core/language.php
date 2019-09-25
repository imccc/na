<?php

class language
{

    protected $_language;

    public function __construct()
    {
        $this->_language = require cfg::v("sys.language") . EXT;
        // $this->_language = require LANGUAGE_PATH . DS . cfg::v("sys.language") . EXT;
    }

    public function local()
    {
        return $this->_language;
    }

}
