<?php
namespace app\admin\model;

use app\admin\library\User as UserLibrary;
use think\Exception;
use think\Model;
use think\Validate;

class User extends Model
{
    protected $updateTime = 'modify_time';

    /**
     * 关联角色
     * @method   role
     * @DateTime 2017-03-31T10:15:17+0800
     * @return   [type]                   [description]
     */
    public function roles()
    {
        // 0 为超级管理员
        if ($this->role == 0) {
            return null;
        }
        return $this->belongsTo("Role", 'role', 'id');
    }
    /**
     * 权限
     * @method   rule
     * @DateTime 2017-03-31T10:16:05+0800
     * @return   [type]                   [description]
     */
    public function rule()
    {
        if ($this->role == 0) {
            return null;
        }
        if ($this->manager == 0) {
            return $this->belongsToMany('Rule', 'user_rule');
        } else {
            return $this->roles->rule();
        }
    }
    /**
     * 修改列时的一些验证操作
     * @method   triggerEdit
     * @DateTime 2017-04-06T12:21:17+0800
     * @param    [type]                   $user [description]
     * @return   [type]                         [description]
     */
    public function triggerEdit($data)
    {
        if (Validate::is($data['password'], 'require')) {
            $validate = validate('User');
            if (!$validate->check($data, [], 'checkpass')) {
                throw new Exception($validate->getError());
            }
        } else {
            $this->readonly('password');
        }
    }

    /**
     * 列表页面
     * @method   scopeList
     * @DateTime 2017-04-06T11:29:47+0800
     * @param    [type]                   $query [description]
     * @return   [type]                          [description]
     */
    protected function scopeList($query)
    {
        $query->where('role', '<>', 0)
            ->field('user.id,user.email,user.manager,user.name,user.status,user.last_ip,user.last_time,role.name as role_name')
            ->join('role', 'role.id=user.role');
    }
    /**
     * 权限
     * @method   scopeAuth
     * @DateTime 2017-04-06T17:04:26+0800
     * @param    [type]                   $query [description]
     * @return   [type]                          [description]
     */
    protected function scopeAuth($query)
    {
        $user = UserLibrary::instance()->getUser();
        if ($user['role'] != 0) {
            $query->where('user.role', $user['role'])->where('user.manager', 0);
        }
    }
    /**
     * 设置登录密码
     * @method   setPasswordAttr
     * @DateTime 2017-03-31T12:29:31+0800
     * @param    [type]                   $password [description]
     * @param    [type]                   $data     [description]
     */
    public function setPasswordAttr($password)
    {
        return md5($password);
    }
}
