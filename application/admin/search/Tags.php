<?php
namespace app\admin\search;

use luffyzhao\helper\Search;

class Tags extends Search
{
    protected $rules = [
        'index' => [
            'name' => ['whereLike', 'name'],
        ],
        'iframe' => [
            'name' => ['whereLike', 'name'],
        ],
    ];
}
