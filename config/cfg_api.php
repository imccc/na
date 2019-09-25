<?php
/**
 * api 配置
 * 支持类型 : json xml
 * 返回模式 ： true / false
 */
return [
    // 类型
    'type' => 'json',

    // 显示与否
    'show' => true,

    // xml数据输出时item带id属性
    'itemid' => false,

    // xml输出时需要转出CDATA的字段,json无效
    'cdata' => [
        'about',
        'head_img',
        'nickname',
    ],
];
