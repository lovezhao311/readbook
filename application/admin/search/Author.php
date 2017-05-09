<?php
namespace app\admin\search;

use luffyzhao\helper\Search;

class Author extends Search
{
    protected $rules = [
        'index' => [
            'name' => ['whereLike', 'name'],
        ],
    ];
}
