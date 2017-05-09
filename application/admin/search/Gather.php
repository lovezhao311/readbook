<?php
namespace app\admin\search;

use luffyzhao\helper\Search;

class Gather extends Search
{
    protected $rules = [
        'index' => [
            'name' => ['whereLike', 'name'],
        ],
    ];
}
