<?php
namespace app\admin\model;

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
}
