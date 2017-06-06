<?php
namespace app\admin\validate;

use luffyzhao\helper\Validate;

class Book extends Validate
{
    protected $rule = [
        'name|书籍名称' => ['require', 'chsDash', 'max:100', 'unique:book,name'],
        'alias|书籍别名' => ['require', 'max:100'],
        'image|书籍封面' => ['require'],
        'isbn|书籍ISBN号' => ['max:20', 'alphaNum'],
        'author_name|书籍作者' => ['max:50'],
        'source_id|书籍来源' => ['exist:source,id'],
        'tags|书籍标签' => ['exist:tags,id'],
        'gather|书籍采集源' => ['array'],
        'types|书籍推荐' => ['array'],
        'remark|书籍说明' => ['max:255'],
        'end_status|完结状态' => ['require', 'in:1,2'],
    ];

    protected $scene = [
        'add' => ['name', 'alias', 'image', 'isbn', 'author_name', 'source_id', 'tags', 'gather', 'remark', 'end_status', 'types'],
        'edit' => ['name', 'alias', 'image', 'isbn', 'author_name', 'source_id', 'tags', 'gather', 'remark', 'end_status', 'types'],
    ];

    protected $requireField = [
        'add' => ['name', 'alias', 'image', 'isbn', 'author_name', 'source_id', 'tags', 'gather', 'remark', 'end_status', 'types'],
        'edit' => ['name', 'alias', 'image', 'isbn', 'author_name', 'source_id', 'tags', 'gather', 'remark', 'end_status', 'types'],
    ];
}
