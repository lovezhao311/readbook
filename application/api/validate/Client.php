<?php
namespace app\api\validate;

use luffyzhao\helper\Validate;

class Client extends Validate
{
    protected $rule = [
        'code|登录凭证' => ['require', 'alphaNum'],
    ];

    protected $scene = [
        'sign' => ['code'],
    ];

    protected $requireField = [
        'sign' => ['code'],
    ];
}
