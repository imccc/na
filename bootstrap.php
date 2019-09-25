<?php
/**
 * 引导程序类  bootstrap
 * @author   sam@imccc.net
 * @since    2019-06-08 13:50:00
 */

//PHP版本检测
if (version_compare(PHP_VERSION, '5.5.0', '<')) {
    die('PHP VERSION: ' . phpversion());
}

//定义公共常量
defined("DS") || define("DS", DIRECTORY_SEPARATOR);
defined("PS") || define("PS", PATH_SEPARATOR);

//默认参数
defined("M") || define("M", "moudel");
defined("C") || define("C", "controller");
defined("A") || define("A", "action");

defined("U") || define("U", 1);

defined("EXT") || define("EXT", ".php");
defined("CFG_PREFIX") || define("CFG_PREFIX", "cfg_");
defined("CONTROLLER_FIX") || define("CONTROLLER_FIX", 'Controller');

// 调试模式
defined("ERROR_REPOT") || define("ERROR_REPOT", true);

defined("DEBUG_SPL") || define("DEBUG_SPL", false);
defined("DEBUG_MEM") || define("DEBUG_MEM", false);
defined("DEBUG_FULL") || define("DEBUG_FULL", true);
defined("DEBUG_TRACE") || define("DEBUG_TRACE", true);
defined("DEBUG_DEFINED") || define("DEBUG_DEFINED", false);
defined("DEBUG_PHPINFO") || define("DEBUG_PHPINFO", false);
defined("CUSTOM_HANDLE") || define("CUSTOM_HANDLE", false);
defined("DEBUG_LOG_MODEL") || define("DEBUG_LOG_MODEL", true);

/**
 * 定义应用常量
 */
defined("NA_PATH") || define("CCC_PATH", dirname(__FILE__) . DS . "na"); //框架目录
defined("APP_PATH") || define("APP_PATH", dirname(dirname(__FILE__)) . DS . "application"); //APP目录
defined("RUN_PATH") || define("RUN_PATH", dirname(APP_PATH) . DS . "runtime"); //RunTime目录
defined("LOG_PATH") || define("LOG_PATH", RUN_PATH . DS . "log"); //RunTime目录

defined("LANGUAGE_PATH")   || define("LANGUAGE_PATH",   NA_PATH . DS . "lang"); //Config目录
defined("CONFIG_DIR_NAME") || define("CONFIG_DIR_NAME", NA_PATH . DS . "config"); //Config目录

defined("CACHE_PATH") || define("CACHE_PATH", RUN_PATH . DS . "cache"); //RunTime目录
defined("DATA_CACHE_PATH") || define("DATA_CACHE_PATH", CACHE_PATH . DS . "data"); //RunTime目录
defined("FILE_CACHE_PATH") || define("FILE_CACHE_PATH", CACHE_PATH . DS . "file"); //RunTime目录
defined("SQL_CACHE_PATH") || define("SQL_CACHE_PATH", CACHE_PATH . DS . "sql"); //RunTime目录

require_once NA_PATH . DS . "core" . DS . "na" . EXT;
(new na)->run();
