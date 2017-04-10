<?php
namespace app\admin\controller;

use app\admin\library\Controller;
use app\admin\model\Role as RoleModel;
use app\admin\model\Rule as RuleModel;

class Role extends Controller
{
    /**
     * 用户组
     * @method   index
     * @DateTime 2017-03-31T13:36:08+0800
     * @return   [type]                   [description]
     */
    public function index()
    {
        if ($this->request->isAjax()) {
            $list = $this->_getSearch(new RoleModel)->scope('list')->paginate();
            $this->result($list->toArray(), 1);
        }
        return $this->fetch();
    }
    /**
     * 添加用户组
     * @method   add
     * @DateTime 2017-03-31T16:39:49+0800
     * @param    string                   $value [description]
     */
    public function add()
    {
        if ($this->request->isAjax()) {
            try {
                $role = $this->save(new RoleModel);
            } catch (Exception $e) {
                $this->error($e->getMessage());
            }
            $this->success('添加用户组[id:' . $role->id . ']', 'role/index');
        }
        $list = RuleModel::scope('role')->all();
        $this->assign('ruleList', toTree(collection($list)->toArray()));
        return $this->fetch();
    }
    /**
     * 修改用户组
     * @method   edit
     * @DateTime 2017-04-01T16:14:17+0800
     * @param    [type]                   $id [description]
     * @return   [type]                       [description]
     */
    public function edit($id)
    {
        $role = RoleModel::get($id);
        if (empty($role)) {
            $this->error('用户组不存在！');
        }
        if ($this->request->isAjax()) {
            try {
                $this->save($role, ['id' => $id], 'edit');
            } catch (Exception $e) {
                $this->error($e->getMessage());
            }
            $this->success('用户组修改[id:' . $id . ']', 'role/index');
        }
        $list = RuleModel::scope('role')->all();
        $this->assign('ruleList', toTree(collection($list)->toArray()));
        $this->assign('role', $role);
        $this->assign('rules', $role->rule()->column('id'));
        return $this->fetch();
    }
    /**
     * 销毁用户组
     * @method   destroy
     * @DateTime 2017-04-05T14:09:43+0800
     * @param    [type]                   $id [description]
     * @return   [type]                       [description]
     */
    public function destroy($id)
    {
        $role = RoleModel::get($id);
        if (empty($role)) {
            $this->error('用户组不存在！');
        }
        try {
            $this->delete($role);
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
        $this->success('删除用户组[id:' . $id . ']', 'role/index');
    }

}
