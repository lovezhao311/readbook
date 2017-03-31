<?php
namespace app\admin\controller;

use app\admin\library\Controller;
use app\admin\model\Rule as RuleModel;

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
            } catch (ValidateException $e) {
                $this->error($e->getError());
            }

            $this->success('登录成功', 'index/index');
        }
        $list = RuleModel::scope('select')->all();
        $this->assign('list', treeSort($list));
        return $this->fetch();
    }

}
