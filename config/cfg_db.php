<?php
return [
    //使用环境
    'model' =>'dev',

    //应用环境
    'env' => [
        'database_type' => 'mysql',
        'database_name' => 'imccc_ICBC',  //bigcapi1_NSAPI
        'server' => 'localhost',
        'username' => 'imccc_ICBC',
        'password' => 'rhine888',
        'charset' => 'utf8',
         // 可选参数
        'port' => 3306,
         // 可选，定义表的前缀
        'prefix' => 'think_',
         // 连接参数扩展, 更多参考 http://www.php.net/manual/en/pdo.setattribute.php
        'option' => [
            PDO::ATTR_CASE => PDO::CASE_NATURAL,
        ],
    ],

    //NSAPI开发环境
    'nsapi' => [
        'database_type' => 'mysql',
        'database_name' => 'imccc_NSAPI',
        'server' => 'localhost',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
         // 可选参数
        'port' => 3306,
         // 可选，定义表的前缀
         'prefix' => 'think_',
         // 连接参数扩展, 更多参考 http://www.php.net/manual/en/pdo.setattribute.php
        'option' => [
            PDO::ATTR_CASE => PDO::CASE_NATURAL,
        ],
    ],

    //最新开发环境
    'dev' => [
        'database_type' => 'mysql',
        'database_name' => 'imccc_nineaspects',
        'server' => 'localhost',
        'username' => 'root',
        'password' => 'root',
        'charset' => 'utf8',
         // 可选参数
        'port' => 3306,
         // 可选，定义表的前缀
        'prefix' => 'imccc_',
         // 连接参数扩展, 更多参考 http://www.php.net/manual/en/pdo.setattribute.php
        'option' => [
            PDO::ATTR_CASE => PDO::CASE_NATURAL,
        ],
    ],
];