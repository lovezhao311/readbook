<?php
namespace app\admin\validate;

use luffyzhao\helper\Validate;

class Tags extends Validate
{
    protected $rule = [
        'name|标签名称' => ['require', 'chsDash', 'max:50', 'unique'],
        'remark|标签说明' => ['max:255'],
        'en_name|英文标签' => ['require', 'max:50', 'alphaDash'],
    ];

    protected $scene = [
        'add' => ['name', 'remark', 'en_name'],
        'edit' => ['name', 'remark', 'en_name'],
    ];

    protected $requireField = [
        'add' => ['name', 'remark', 'en_name'],
        'edit' => ['name', 'remark', 'en_name'],
    ];
}
