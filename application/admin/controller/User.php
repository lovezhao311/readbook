<?php
namespace app\admin\controller;

use app\admin\library\Controller;
use app\admin\model\Role;
use app\admin\model\User as UserModel;
use think\Exception;

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
            $list = $this->_getSearch(new UserModel)->scope('list,auth')->paginate();
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
                $this->save(new UserModel);
            } catch (Exception $e) {
                $this->error($e->getMessage());
            }
            $this->success('添加成功', 'user/index');
        }
        $role = Role::scope('option,auth')->all();
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
        $user = UserModel::scope('auth')->get($id);
        if (empty($user)) {
            $this->error('用户不存在！');
        }
        if ($this->request->isAjax()) {
            try {
                $this->save(new UserModel, ['id' => $id], 'edit');
            } catch (Exception $e) {
                $this->error($e->getMessage());
            }
            $this->success('修改成功', 'user/index');
        }
        $role = Role::scope('option,auth')->all();
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
                $this->save(new UserModel, ['id' => $id], 'status', 'get', '', ['status']);
            } catch (Exception $e) {
                $this->error($e->getMessage());
            }
            $this->success('修改成功', 'user/index');
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
        $user = UserModel::scope('auth')->get($id);
        if (empty($user)) {
            $this->error('用户不存在！');
        }

        if ($this->request->isAjax()) {
            $data = $this->request->post('data/a');
            try {
                $this->validate($data, 'allot');
                $user->rule()->detach();
                // 添加现在的数据
                $rules = array_keys(array_filter($data['rule']));
                if (!empty($rules)) {
                    $user->rule()->attach($rules, ['role_id' => $user['role']]);
                }
            } catch (Exception $e) {
                $this->error($e->getMessage());
            }
            $this->success('修改成功', 'user/index');
        }

        $this->assign('ruleList', toTree(collection($user->roles->rule()->where('isadmin', 0)->select())->toArray()));
        $this->assign('user', $user);
        return $this->fetch();
    }

}
