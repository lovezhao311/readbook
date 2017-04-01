<?php
namespace app\admin\controller;

use app\admin\library\Controller;
use app\admin\library\User;
use think\Exception;

class Index extends Controller
{
    /**
     * 登录
     * @method   login
     * @DateTime 2017-03-31T11:45:13+0800
     * @return   [type]                   [description]
     */
    public function login()
    {
        if ($this->request->isAjax()) {

            try {
                // 验证请求的数据
                $this->validate([], 'login');
                // 执行登录
                User::instance()->login();

            } catch (Exception $e) {
                $this->error($e->getMessage());
            }

            $this->success('登录成功', 'index/index');
        }
        $this->view->engine->layout(true);
        return $this->fetch();
    }
    /**
     * 系统框架
     * @method   index
     * @DateTime 2017-03-31T13:36:08+0800
     * @return   [type]                   [description]
     */
    public function index()
    {
        $this->view->engine->layout(true);
        $leftmenu = User::instance()->getMenu();
        $this->assign('list', $leftmenu);
        return $this->fetch();
    }
    /**
     * 首页面板
     * @method   main
     * @DateTime 2017-03-31T15:00:46+0800
     * @return   [type]                   [description]
     */
    public function main()
    {

    }
}
