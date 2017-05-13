<?php
namespace app\admin\search;

use luffyzhao\helper\Search;

class Chapter extends Search
{
    protected $rules = [
        'index' => [
            'name' => ['whereLike', 'a.name'],
            'subsection_id' => ['where', 'a.subsection_id'],
            'status' => ['where', 'a.status'],
            'error' => ['where', 'a.error'],
        ],
    ];
}
