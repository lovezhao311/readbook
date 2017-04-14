<?php
namespace app\admin\controller;

use app\admin\library\Controller;
use app\admin\model\Role as RoleModel;
use app\admin\model\Rule as RuleModel;
use think\Db;

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
            $list = $this->search(new RoleModel)->scope('list')->paginate();
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

            Db::startTrans();
            try {
                $role = new RoleModel;
                $this->save($role);
                $data = $this->request->post('data/a');
                // 添加现在的数据
                $rules = array_keys(array_filter($data['rule']));
                if (!empty($rules)) {
                    $role->rule()->attach($rules);
                }

                Db::commit();
            } catch (Exception $e) {
                Db::rollback();
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

            Db::startTrans();
            try {
                // 更新关联表
                $data = $this->request->post('data/a');
                // 原有数据
                $oldrules = $role->rule()->column('id');
                // 提交的数据
                $rules = array_keys(array_filter($data['rule']));
                // 要删除的数据
                $del = array_values(array_diff($oldrules, $rules));
                if (!empty($del)) {
                    // 用户权限关联表
                    $role->userRule()->detach($del);
                    // 部门权限关联表
                    $role->rule()->detach($del);
                }
                // 要添加的数据
                $add = array_values(array_diff($rules, $oldrules));
                if (!empty($add)) {
                    $role->rule()->attach($add);
                }
                // 更新主表
                $this->save($role, [], 'edit');
                // 提交
                Db::commit();
            } catch (Exception $e) {
                // 回滚
                Db::rollback();
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
        Db::startTrans();
        try {
            // 用户权限关联表
            $role->userRule()->detach();
            // 部门权限关联表
            $role->rule()->detach();

            $this->delete($role);
            Db::commit();
        } catch (Exception $e) {
            Db::rollback();
            $this->error($e->getMessage());
        }
        $this->success('删除用户组[id:' . $id . ']', 'role/index');
    }

}
