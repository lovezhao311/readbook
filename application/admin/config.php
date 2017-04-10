<?php
//配置文件
return [
    // 登录标识
    'session' => [
        'prefix' => 'luffy_auth',
        'type' => '',
        'auto_start' => true,
        // 登录标识
        'login' => 'User',
        // 登录验证
        'login_auth' => false,
    ],

    // 模板
    'template' => [
        'layout_on' => true,
        'tpl_cache' => false,
        'taglib_pre_load' => "\\app\\admin\\taglib\\Form,\\app\\admin\\taglib\\Table",
    ],

    //分页配置
    'paginate' => [
        'type' => \app\admin\library\Laypage::class,
        'var_page' => 'page',
        'list_rows' => 15,
    ],

    'handle_log' => [
        'type' => 'mysql',
    ],
];
