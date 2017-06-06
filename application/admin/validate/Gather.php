<?php
namespace app\admin\validate;

use luffyzhao\helper\Validate;

class Gather extends Validate
{
    protected $rule = [
        'name|采集名称' => ['require', 'length:2,50', 'unique:gather,name'],
        'search|搜索页面' => ['require', 'max:255'],
        'search_regular|搜索页面正则' => ['require', 'max:255'],
        'remark|采集说明' => ['max:255'],
        'title|标题替换' => ['array'],
        'list|列表页面正则' => ['require', 'max:255'],
        'content|章节内容正则' => ['require', 'max:255'],
        'replace|内容替换' => ['array'],
    ];

    protected $scene = [
        'add' => ['name', 'remark', 'title', 'list', 'content', 'replace', 'search', 'search_regular'],
        'edit' => ['name', 'remark', 'title', 'list', 'content', 'replace', 'search', 'search_regular'],
    ];

    protected $requireField = [
        'add' => ['name', 'remark', 'title', 'list', 'content', 'replace', 'search', 'search_regular'],
        'edit' => ['name', 'remark', 'title', 'list', 'content', 'replace', 'search', 'search_regular'],
    ];
}
