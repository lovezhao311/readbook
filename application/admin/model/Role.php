<?php
namespace app\admin\model;

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
     * 添加用户组时注册的触发事件
     * @method   triggerAdd
     * @DateTime 2017-04-05T16:10:25+0800
     * @return   [type]                   [description]
     */
    public function triggerAdd(array $data)
    {
        $this->triggerRule($data['rule']);
    }

    /**
     * 添加用户组时注册的触发事件
     * @method   triggerAdd
     * @DateTime 2017-04-05T16:10:25+0800
     * @return   [type]                   [description]
     */
    public function triggerEdit(array $data)
    {
        // 维护关联表
        $this->triggerRule($data['rule']);
        // 维护部门下用户的权限
        $this->triggerUserRule($data['rule']);
    }
    /**
     * 添加&修改用户组后绑定相关的权限
     * @method   triggerRule
     * @DateTime 2017-04-05T16:15:53+0800
     * @param    [type]                   $data 提交过来的rule数据
     * @return   [type]                         [description]
     */
    protected function triggerRule(array $rules)
    {
        self::afterWrite(function ($role) use ($rules) {
            // 删除原有数据
            $role->rule()->detach();

            // 添加现在的数据
            $data = array_keys(array_filter($rules));
            if (!empty($data)) {
                $role->rule()->attach($data);
            }
        });
    }
    /**
     * 删除时相关监听
     * @method   triggerDelete
     * @DateTime 2017-04-05T17:52:17+0800
     * @param    array                    $rules [description]
     * @return   [type]                          [description]
     */
    protected function triggerDelete($rules = [])
    {
        self::beforeDelete(function ($role) {
            if (empty($this->data) || !isset($this->data[$this->getPk()])) {
                throw new Exception("操作失败，请刷新页面重试！");
            }
            if ($role->user()->count() > 0) {
                throw new Exception("操作失败，用户组下还有用户不能删除！");
            }
        });

        self::afterDelete(function ($role) {
            if (empty($this->data) || !isset($this->data[$this->getPk()])) {
                throw new Exception("操作失败，请刷新页面重试！");
            }
            $role->rule()->detach();
        });
    }
    /**
     * 维护部门下用户的权限
     * @method   triggerUserRule
     * @DateTime 2017-04-05T17:12:27+0800
     * @param    array                    $rules [description]
     * @return   [type]                          [description]
     */
    protected function triggerUserRule(array $rules)
    {
        self::beforeWrite(function ($role) use ($rules) {
            $oldRules = $role->rule()->column('id');
            $newRules = array_keys(array_filter($rules));
            $del = array_diff($oldRules, $newRules);
            $role->userRule()->detach($del);
        });
    }
}
