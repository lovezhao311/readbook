<?php
namespace app\admin\model;

use app\admin\library\User as UserLibrary;
use think\Exception;
use think\Model;

class Role extends Model
{
    protected $updateTime = 'modify_time';

    /**
     * 关联角色
     * @method   role
     * @DateTime 2017-03-31T10:15:17+0800
     * @return   [type]                   [description]
     */
    public function user()
    {
        return $this->hasMany("User", 'role', 'id');
    }
    /**
     * 权限
     * @method   rule
     * @DateTime 2017-03-31T10:16:05+0800
     * @return   [type]                   [description]
     */
    public function rule()
    {
        return $this->belongsToMany('Rule', 'role_rule');
    }
    /**
     * 用户组下用户的权限
     * @method   userRule
     * @DateTime 2017-04-05T17:24:24+0800
     * @return   [type]                   [description]
     */
    public function userRule()
    {
        return $this->belongsToMany('Rule', 'user_rule');
    }
    /**
     * 用户组列表
     * @method   scopeList
     * @DateTime 2017-04-06T11:46:49+0800
     * @param    [type]                   $query [description]
     * @return   [type]                          [description]
     */
    protected function scopeList($query)
    {
        $query->field('id,name,remark')->order('create_time DESC');
    }
    /**
     * option选择
     * @method   scopeOption
     * @DateTime 2017-04-06T11:47:59+0800
     * @param    [type]                   $query [description]
     * @return   [type]                          [description]
     */
    protected function scopeOption($query)
    {
        $query->field('id,name')->order('create_time DESC');
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
            $query->where('role.id', $user['role']);
        }
    }
    /**
     * 删除时相关监听
     * @method   triggerDelete
     * @DateTime 2017-04-05T17:52:17+0800
     * @param    array                    $rules [description]
     * @return   [type]                          [description]
     */
    public function triggerDelete($rules = [])
    {
        if ($this->user()->count() > 0) {
            throw new Exception("操作失败，用户组下还有用户不能删除！");
        }
    }

}
