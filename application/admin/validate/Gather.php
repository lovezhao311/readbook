<?php
namespace app\admin\validate;

use luffyzhao\helper\Validate;

class Gather extends Validate
{
    protected $rule = [
        'name|采集名称' => ['require', 'chsDash', 'length:2,10', 'unique'],
        'remark|采集说明' => ['max:255'],
        'url|采集网址' => ['require', 'max:255', 'url'],
        'search|搜索页面正则' => ['require', 'max:255'],
        'list|列表页面正则' => ['require', 'max:255'],
        'content|章节内容正则' => ['require', 'max:255'],
    ];

    protected $scene = [
        'add' => ['name', 'remark', 'url', 'search', 'list', 'content'],
        'edit' => ['name', 'remark', 'url', 'search', 'list', 'content'],
    ];

    protected $requireField = [
        'add' => ['name', 'remark', 'url', 'search', 'list', 'content', 'replace'],
        'edit' => ['name', 'remark', 'url', 'search', 'list', 'content', 'replace'],
    ];
}
