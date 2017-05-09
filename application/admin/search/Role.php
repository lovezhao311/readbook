<?php
namespace app\admin\search;

use luffyzhao\helper\Search;

class Role extends Search
{
    protected $rules = [
        'index' => [
            'name' => ['whereLike', 'name'],
        ],
    ];
}
