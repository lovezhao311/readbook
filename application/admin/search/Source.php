<?php
namespace app\admin\search;

use luffyzhao\helper\Search;

class Source extends Search
{
    protected $rules = [
        'index' => [
            'name' => ['whereLike', 'name'],
        ],
    ];
}
