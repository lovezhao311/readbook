<?php
namespace app\admin\controller;

use app\admin\library\Controller;
use app\admin\model\Role;
use app\admin\model\User as UserModel;
use think\Db;
use think\Exception;
use think\Validate;

class User extends Controller
{
    /**
     * 用户
     * @method   index
     * @DateTime 2017-03-31T13:36:08+0800
     * @return   [type]                   [description]
     */
    public function index()
    {
        if ($this->request->isAjax()) {
            $model = UserModel::scope('list,auth');
            $list = $this->search($model)->paginate();
            $this->result($list->toArray(), 1);
        }
        return $this->fetch();
    }
    /**
     * 添加用户
     * @method   add
     * @DateTime 2017-03-31T16:39:49+0800
     * @param    string                   $value [description]
     */
    public function add()
    {
        if ($this->request->isAjax()) {
            try {

                $user = new UserModel;
                $this->save($user);

            } catch (Exception $e) {
                $this->error($e->getMessage());
            }
            $this->success('添加用户[id:' . $user->id . ']', 'user/index');
        }
        $role = Role::scope('option,auth')->select();
        $this->assign('role', $role);
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
        $user = UserModel::scope('auth')->find($id);
        if (empty($user)) {
            $this->error('用户不存在！');
        }
        if ($this->request->isAjax()) {
            try {
                $this->save($user, [], 'edit');
            } catch (Exception $e) {
                $this->error($e->getMessage());
            }
            $this->success('修改用户[id:' . $id . ']', 'user/index');
        }
        $role = Role::scope('option,auth')->select();
        $this->assign('role', $role);
        $this->assign('user', $user);
        return $this->fetch();
    }
    /**
     * 禁用&启用用户
     * @method   destroy
     * @DateTime 2017-04-05T14:09:43+0800
     * @param    [type]                   $id [description]
     * @return   [type]                       [description]
     */
    public function status($id)
    {
        if ($this->request->isAjax()) {
            try {
                $user = new UserModel;
                $this->save($user, ['id' => $id], 'status', [], 'get', 'data/a', ['status']);
            } catch (Exception $e) {
                $this->error($e->getMessage());
            }
            $this->success('修改用户[id:' . $id . ']', 'user/index');
        }
    }
    /**
     * 分配权限
     * @method   allot
     * @DateTime 2017-04-06T17:41:13+0800
     * @param    [type]                   $id [description]
     * @return   [type]                       [description]
     */
    public function allot($id)
    {
        $user = UserModel::scope('auth')->find($id);
        if (empty($user)) {
            $this->error('用户不存在！');
        }

        if ($this->request->isAjax()) {
            $data = $this->request->post('data/a');

            Db::startTrans();
            try {

                $this->validate($data, 'allot');
                $user->rule()->detach();
                // 添加现在的数据
                $rules = array_keys(array_filter($data['rule']));
                if (!empty($rules)) {
                    $user->rule()->attach($rules, ['role_id' => $user['role']]);
                }

                Db::commit();
            } catch (Exception $e) {
                Db::rollback();
                $this->error($e->getMessage());
            }
            $this->success('用户分配权限[id:' . $id . ']', 'user/index');
        }

        $this->assign('ruleList', toTree(collection($user->roles->rule()->where('isadmin', 0)->select())->toArray()));
        $this->assign('user', $user);
        return $this->fetch();
    }

}
