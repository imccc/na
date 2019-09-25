<?php

/**
 * Cookie设置
 */
return [
    'prefix' => 'imccc_', // cookie 名称前缀
    'admin' => [
        'flg' => 'admin', // 名称
        'expire' => 36000, // cookie 保存时间
        'path' => '/admin', // cookie 保存路径
    ],
    'home' => [
        'flg' => 'home', // 名称
        'expire' => 36000, // cookie 保存时间
        'path' => '/home', // cookie 保存路径
    ],
    'api' => [
        'flg' => 'api', // 名称
        'expire' => 36000, // cookie 保存时间
        'path' => '/api', // cookie 保存路径
    ],
    'domain' => '', // cookie 有效域名
    'secure' => false, //  cookie 启用安全传输
    'httponly' => '', // httponly设置
    'setcookie' => true, // 是否使用 setcookie
];
