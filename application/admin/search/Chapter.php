<?php
namespace app\admin\search;

use luffyzhao\helper\Search;

class Chapter extends Search
{
    protected $rules = [
        'index' => [
            'name' => ['whereLike', 'a.name'],
            'group' => ['where', 'a.group'],
            'status' => ['where', 'a.status'],
            'error' => ['where', 'a.error'],
        ],
    ];
}
