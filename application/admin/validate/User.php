<?php
namespace app\admin\validate;

use think\Validate;

class User extends Validate
{
    use \app\admin\library\traits\Validate;

    protected $rule = [
        'name|用户名称' => ['require', 'chs', 'length:2,10'],
        'email|邮箱' => ['require', 'email', 'unique:user'],
        'password|密码' => ['require', 'length:6,12'],
        'confirm|确认密码' => ['require', 'confirm:password'],
        'role|用户组' => ['require', 'exist:role'],
        'manager|管理员' => ['in:0,1'],
        'status|用户状态' => ['in:0,1'],
        'rule|用户权限' => ['require', 'array'],
    ];

    protected $scene = [
        'add' => ['name', 'email', 'password', 'confirm', 'role', 'manager', 'status'],
        'edit' => ['name', 'email', 'role', 'manager', 'status'],
        'allot' => ['rule'],
        'checkpass' => ['password', 'confirm'],
        'status' => ['status'],
    ];
}
