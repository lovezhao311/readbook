<?php
return [
    'app_debug' => true,
    // 应用Trace
    'app_trace' => false,

    'default_module' => 'admin',

    // 验证码
    'captcha' => [
        // 验证码字符集合
        'codeSet' => '2345678abcdefhijkmnpqrstuvwxyzABCDEFGHJKLMNPQRTUVWXY',
        // 验证码字体大小(px)
        'fontSize' => 14,
        // 是否画混淆曲线
        'useCurve' => false,
        //
        'useNoise' => false,
        // 验证码图片高度
        'imageH' => 38,
        // 验证码图片宽度
        'imageW' => 102,
        // 验证码位数
        'length' => 4,
        // 验证成功后是否重置
        'reset' => true,
    ],

    'log' => [
        // 日志记录方式，内置 file socket 支持扩展
        'type' => 'socket',
        'host' => 'slog.thinkphp.cn',
        // 'force_client_ids' => ['slog_bd4ff4'],
        'show_included_files' => true,
        // 日志保存目录
        'path' => LOG_PATH,
        // 日志记录级别
        'level' => [],
    ],
];
