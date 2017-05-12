<?php
namespace app\admin\validate;

use luffyzhao\helper\Validate;

class Gather extends Validate
{
    protected $rule = [
        'name|采集名称' => ['require', 'length:2,50', 'unique:gather,name'],
        'remark|采集说明' => ['max:255'],
        'title|标题替换' => ['array'],
        'list|列表页面正则' => ['require', 'max:255'],
        'content|章节内容正则' => ['require', 'max:255'],
        'replace|内容替换' => ['array'],
    ];

    protected $scene = [
        'add' => ['name', 'remark', 'title', 'list', 'content', 'replace'],
        'edit' => ['name', 'remark', 'title', 'list', 'content', 'replace'],
    ];

    protected $requireField = [
        'add' => ['name', 'remark', 'title', 'list', 'content', 'replace'],
        'edit' => ['name', 'remark', 'title', 'list', 'content', 'replace'],
    ];
}
