<?php
class nahandle
{
    public static $_header = <<<EOF
<!DOCTYPE HTML>
    <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
            <title>Nine Aspects Framework (NA) Debug Information</title>
            <style>
            .header,.content,.footer{
                width:876px;
                background-color:#ddd;
                border-radius:10px;
            }
            .header,.footer{
                padding:16px 36px;
            }
            .content,.footer{
                margin:6px auto;
                border-bottom:3px solid #aaa;
            }
            .header{
                margin:16px auto;
                border-bottom:5px solid red;
            }
            .content{
                padding:6px 36px;
            }
            </style>
        </head>
    <body>
    <div class= "header">
        <h1>Nine Aspects Framework (NA) Debug Information</h1>
        <p>
            <span id='time'></span><br>
            http://open.imccc.net/na/v2<br>
            http://open.imccc.net/licenses/LICENSE-2.0<br>
        </p>
    </div>
EOF;

    public static $_head = <<<EOF
    <div class="content">
        <pre>
EOF;

    public static $_end = <<<EOF
        </pre>
    </div>
EOF;

    public static $_footer = <<<EOF

        <div class="footer">  &copy 2019 imccc.net </div>
    </body>
    <script>
      //  setInterval("document.getElementById('time').innerHTML=new Date().toLocaleString()+' 星期'+'日一二三四五六'.charAt(new Date().getDay());",1000);
        document.getElementById("time").innerHTML=new Date();
    </script>
</html>
EOF;

  
    public static function appError($errno, $errstr, $errfile, $errline)
    {
        //如果不是管理员就过滤实际路径
        $errfile = str_replace(getcwd(), "", $errfile);
        $errstr = str_replace(getcwd(), "", $errstr);
        switch ($errno) {
            case E_ERROR:
                echo "ERROR: [ID $errno] $errstr (Line: $errline of $errfile) \n";
                echo "程序已经停止运行，请联系管理员。";
                //遇到Error级错误时退出脚本
                exit;
                break;

            case E_WARNING:
                echo "WARNING: [ID $errno] $errstr (Line: $errline of $errfile) \n";
                break;

            default:
                //不显示Notice级的错误
                break;
        }
    }

    public static function appException($e)
    {
        echo "<b>Exception:</b> ", $e->getMessage() 
        ." in ". $e->getFile() ." at line: ".$e->getLine()
        ."<br> code: ".$e->getCode();
    }

    public static function systemError()
    {
        debug::log();
        $_error = error_get_last();
        if ($_error) {
            if (DEBUG_FULL) {
                echo static::$_header;
                static::go();
            }

            $t = "";
            if (DEBUG_FULL) {
                $t .= static::$_head;
            }
            $t .= "<a name='#last' id='last'></a><h3>LAST ERROR:</h3>";
            $t .= "Message: " . $_error['message'] . "</br>";
            $t .= "File: " . $_error['file'] . "</br>";
            $t .= "Line: " . $_error['line'] . "</br>";
            $t .= "Type: " . $_error['type'] . "</br>";
            if (DEBUG_FULL) {
                $t .= static::$_end;
            }
            echo $t;

            if (DEBUG_MEM) {
                static::mem();
            }

            if (DEBUG_SPL) {
                static::spl();
            }

            if (DEBUG_DEFINED) {
                static::defined();
            }


            if (DEBUG_PHPINFO) {
                echo "<a name='#phpinfo' id='phpinfo'></a><h3>PHPINFO</h3>";
                phpinfo();
            }

            if (DEBUG_FULL) {
                echo static::$_footer;
            }

        }
    }

    //显示自动注册的类
    public static function spl()
    {
        echo static::$_head;
        echo "<a name ='#spl' id='spl'></a><h3>SPL REGISTER:</h3>";
        print_r(spl_autoload_functions());
        echo static::$_end;
    }

    //常量
    public function defined()
    {
        echo static::$_head;
        echo "<a name='#defined' id='defined'></a><h3>DEFINED</h3>";
        print_r(get_defined_constants(true)['user']);
        echo static::$_end;
    }

    // 内存
    public function mem()
    {
        echo static::$_head;
        echo "<a name='#mem' id='mem'></a><h3>MEMORY:</h3>";
        $mp = static::convert(memory_get_peak_usage());
        $md = static::convert(memory_get_usage());
        $dv = static::convert($mp - $md);
        $mm = ["PEAK" => $mp, "USED" => $md, "D-VALUE" => $dv];
        print_r($mm);
        echo static::$_end;
    }

    //输出导航
    public static function go()
    {
        $s = static::$_head;
        if (DEBUG_MEM) {
            $s .= "<a href='#mem'>MEMORY</a> / ";
        }

        if (DEBUG_SPL) {
            $s .= "<a href='#spl'>SPL</a> / ";
        }

        if (DEBUG_DEFINED) {
            $s .= "<a href='#defined'>DEFINED</a> / ";
        }

        if (DEBUG_PHPINFO) {
            $s .= "<a href='#phpinfo'>PHPINFO</a> / ";
        }
        $s .= static::$_end;
        echo $s;
    }

    // 字节转换
    public function convert($size)
    {
        $unit = array('byte', 'kb', 'mb', 'gb', 'tb', 'pb');
        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
    }

}
