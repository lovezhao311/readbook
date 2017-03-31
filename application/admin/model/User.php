<?php
namespace app\admin\model;

use think\Model;

class User extends Model
{
    protected $updateTime = 'modify_time';

    /**
     * 关联角色
     * @method   role
     * @DateTime 2017-03-31T10:15:17+0800
     * @return   [type]                   [description]
     */
    public function role()
    {
        // 0 为超级管理员
        if ($this->role == 0) {
            return null;
        }
        return $this->hasOne("Role", 'id', 'role');
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
            return $this->role->rule();
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
