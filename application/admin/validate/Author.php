<?php
namespace app\admin\validate;

use luffyzhao\helper\Validate;

class Author extends Validate
{
    protected $rule = [
        'name|来源名称' => ['require', 'chsDash', 'length:2,10', 'unique'],
        'remark|来源说明' => ['max:255'],
    ];

    protected $scene = [
        'add' => ['name', 'remark'],
        'edit' => ['name', 'remark'],
        'status' => ['status'],
    ];

    protected $requireField = [
        'add' => ['name', 'remark'],
        'edit' => ['name', 'remark'],
        'status' => ['status'],
    ];
}
