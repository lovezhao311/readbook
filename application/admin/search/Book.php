<?php
namespace app\admin\search;

use luffyzhao\helper\Search;

class Book extends Search
{
    protected $rules = [
        'index' => [
            'isbn' => ['whereLike', 'a.isbn'],
            'name' => ['whereLike', 'a.name'],
            'author' => ['whereLike', 'au.name'],
            'end_status' => ['where', 'a.end_status'],
        ],
    ];
}
