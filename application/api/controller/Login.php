<?php
namespace app\api\controller;

use \think\Controller;

/**
 *
 */
class Login extends Controller
{

    public function index()
    {
        return $this->error('用户不存在');
    }
}
