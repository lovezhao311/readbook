<?php
namespace app\admin\validate;

use luffyzhao\helper\Validate;

class Chapter extends Validate
{
    protected $rule = [
        'name|章节标题' => ['require', 'length:1,100'],
        'status|采集状态' => ['require', 'in:0,1'],
        'error|报错状态' => ['require', 'in:0,1'],
    ];

    protected $scene = [
        'edit' => ['name', 'status', 'error'],
    ];

    protected $requireField = [
        'edit' => ['name', 'status', 'error', 'content'],
    ];
}
