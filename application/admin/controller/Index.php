<?php
namespace app\admin\controller;

use app\admin\library\Controller;
use app\admin\library\User;
use think\Exception;
use think\exception\ValidateException;

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
            } catch (ValidateException $e) {
                $this->error($e->getError());
            }

            $this->success('登录成功', 'index/index');
        }
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
