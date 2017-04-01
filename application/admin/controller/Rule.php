<?php
namespace app\admin\controller;

use app\admin\library\Controller;
use app\admin\model\Rule as RuleModel;
use think\Exception;

class Rule extends Controller
{
    /**
     * 权限菜单
     * @method   index
     * @DateTime 2017-03-31T13:36:08+0800
     * @return   [type]                   [description]
     */
    public function index()
    {
        if ($this->request->isAjax()) {
            $list = RuleModel::scope('list')->all();
            $this->result(treeSort($list), 1);
        }
        return $this->fetch();
    }
    /**
     * 添加权限菜单
     * @method   add
     * @DateTime 2017-03-31T16:39:49+0800
     * @param    string                   $value [description]
     */
    public function add()
    {
        if ($this->request->isAjax()) {
            try {
                $this->save(new RuleModel);
            } catch (Exception $e) {
                $this->error($e->getMessage());
            }
            $this->success('添加成功', 'rule/index');
        }
        $list = RuleModel::scope('select')->all();
        $this->assign('list', treeSort($list));
        return $this->fetch();
    }
    /**
     * 修改
     * @method   edit
     * @DateTime 2017-04-01T16:14:17+0800
     * @param    [type]                   $id [description]
     * @return   [type]                       [description]
     */
    public function edit($id)
    {
        $rule = RuleModel::get($id);
        if (empty($rule)) {
            $this->error('菜单权限不存在！');
        }
        if ($this->request->isAjax()) {
            try {
                $this->save($rule, ['id' => $id], 'edit');
            } catch (Exception $e) {
                $this->error($e->getMessage());
            }
            $this->success('修改成功', 'rule/index');
        }
        $list = RuleModel::scope('select')->all();
        $this->assign('rule', $rule);
        $this->assign('list', treeSort($list));
        return $this->fetch();
    }

}
