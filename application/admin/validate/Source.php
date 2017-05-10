<?php
namespace app\admin\validate;

use luffyzhao\helper\Validate;

class Source extends Validate
{
    protected $rule = [
        'name|来源名称' => ['require', 'chsDash', 'length:2,10', 'unique'],
        'remark|来源说明' => ['max:255'],
        'url|来源网址' => ['require', 'max:255', 'url'],
    ];

    protected $scene = [
        'add' => ['name', 'remark', 'url'],
        'edit' => ['name', 'remark', 'url'],
    ];

    protected $requireField = [
        'add' => ['name', 'remark', 'url'],
        'edit' => ['name', 'remark', 'url'],
    ];
}
