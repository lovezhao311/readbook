<?php
namespace app\admin\validate;

use think\Validate;

class Index extends Validate
{
    use \app\admin\library\traits\Validate;

    protected $rule = [
        'email|登录邮箱' => ['require', 'email'],
        'password|登录密码' => ['require', 'password'],
        'confirm|确认密码' => ['require', 'confirm:password'],
        'captcha|验证码' => 'require|captcha',
    ];

    protected $scene = [
        'login' => ['email', 'password', 'captcha'],
        'personal' => ['password', 'confirm'],
    ];
}
