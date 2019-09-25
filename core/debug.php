<?php

class debug
{
    /**
     * 打印错误
     */
    public static function report()
    {
        if (cfg::v("debug.on")) {
            error_reporting(-1);
        } else {
            error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
        }
    }

    /**
     * 写入文件
     */
    public static function write($type = null, $data = null)
    {
        if (!empty($data)) {
            $info = print_r($data, 1);
            $file = LOG_PATH . DS . date("Y-m-d-H", time());
            error_log($info, 3, ($file . "_" . $type . "_.log"));
        }
    }

    /**
     * 记录SQL
     */
    public static function sql($info)
    {
        if (cfg::v("debug.sql")) {
            self::write('sql', $info);
        }
    }
    /**
     * 记录info
     */
    public static function info($info)
    {
        if (cfg::v("debug.info")) {
            self::write('info', $info);
        }
    }
    /**
     * 记录log
     */
    public static function log()
    {
        if (cfg::v("debug.log")) {
            $time = date('m-d H:i:s');
            $backtrace = debug_backtrace();
            $backtrace_line = array_shift($backtrace); // 哪一行调用的log方法
            $backtrace_call = array_shift($backtrace); // 谁调用的log方法

            $file = substr($backtrace_line['file'], strlen($_SERVER['DOCUMENT_ROOT']));
            $line = $backtrace_line['line'];
            $class = isset($backtrace_call['class']) ? $backtrace_call['class'] : '';
            $type = isset($backtrace_call['type']) ? $backtrace_call['type'] : '';
            $func = $backtrace_call['function'];

            $client = $_SERVER['REMOTE_ADDR'] . ":" . $_SERVER['REMOTE_PORT'];
            $req = $_SERVER['REQUEST_METHOD'] . ":" . $_SERVER['REQUEST_URI'];
            $err = error_get_last();

            $msg = $client . " -> " . $req;

            $info = "$time $file:$line $class$type$func  ≡≡≡≡ " . $msg . print_r($err, 1) . "  \n";
            if (cfg::v("debug.trace")) {
                $info .= print_r($backtrace, 1) . "\n";
            }

            self::write('log', $info);
        }
    }

    /**
     * 显示信息
     */
    public static function display()
    {
        if (cfg::v('debug.display')) {
            $hr = "<hr style='border-top: 1px solid rgba(0, 0, 0, 0.1);border-bottom: 1px solid rgba(255, 255, 255, 0.3);' />";

            echo "<div style='width:65%;background:#ddd;padding:50px;'>";

            echo "MEMORY:<br />";
            $mp = memory_get_peak_usage();
            $md = memory_get_usage();
            $mm = ["PEAK" => $mp, "USED" => $md, "D-VALUE" => ($mp - $md)];
            echo "<pre>";
            print_r($mm);
            echo "</pre>" . $hr;

            echo "CPU:<br /><pre>";
            print_r(getrusage());
            echo "</pre>" . $hr;

            echo "DEFINED<br /><pre>";
            print_r(get_defined_constants(true)['user']);
            echo "</pre>" . $hr;

            echo "TRACE:<b r/><pre>";
            if (cfg::v("debug.args")) {
                $tc = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
            } else {
                $tc = debug_backtrace();
            }
            print_r($tc);
            echo "</pre>" . $hr;

            echo "ERROR:<br /><pre>";
            print_r(error_get_last());
            echo "</pre></div>";
        }
    }
}
