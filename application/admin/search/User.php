<?php
namespace app\admin\search;

use app\admin\library\Search;

class User extends Search
{
    protected $rules = [
        'index' => [
            'name' => ['whereLike', 'user.name'],
        ],
    ];
}
