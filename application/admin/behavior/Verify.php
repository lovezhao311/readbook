<?php
namespace app\admin\behavior;

use \app\admin\library\User;

\think\Loader::import('controller/Jump', TRAIT_PATH, EXT);
class Verify
{
    use \traits\controller\Jump;
    /**
     * 不需要验证登录的uri
     * @var array
     */
    protected $_noVerifyLogin = [
        'index/login',
    ];
    /**
     * 不要验证权限的uri
     * @var array
     */
    protected $_noVerify = [
        'index/index',
        'index/logout',
    ];

    public function actionBegin(&$params)
    {
        // 不需要验证登录直接返回
        if ($this->noVerify()) {
            return;
        }
        // 是否有登录
        if (!$this->hasLogin()) {
            $this->error('您还没有登录！', 'index/login');
        }
        // 登录之后不需要验证
        if ($this->noVerify(true)) {
            return;
        }
        // 权限 验证
        if ($this->validateRule() === false) {
            $this->error('您还没有权限操作！');
        }

    }

    /**
     * 获取Uri
     * @method   _uri
     * @DateTime 2017-03-31T09:48:07+0800
     * @return   [type]                   [description]
     */
    protected function getUri()
    {
        return strtolower(request()->controller()) . '/' . strtolower(request()->action());
    }

    /**
     * uri是否需要验证
     * @method   noVerify
     * @DateTime 2017-03-31T09:53:39+0800
     * @param    bool                     $login 是否有登录
     * @return   [type]                          [description]
     */
    protected function noVerify($login = false)
    {
        if ($login === false) {
            return in_array($this->getUri(), $this->_noVerifyLogin);
        } else {
            return in_array($this->getUri(), $this->_noVerify);
        }
    }

    /**
     * 是否有登录
     * @return mixed
     */
    protected function hasLogin()
    {
        return session(config('session.login'));
    }

    /**
     * 验证权限
     * @method   validateRule
     * @DateTime 2017-03-31T10:01:38+0800
     * @return   [type]                   [description]
     */
    protected function validateRule()
    {
        $user = User::instance()->getUser();
        if ($user == null) {
            $this->error('您还没有登录！', 'index/login');
        }
        if ($user['role'] == 0) {
            return true;
        }

        $cacheKey = "user_rule_{$user['id']}_" . $this->getUri();
        // 先看session
        if (config('session.login_auth') && session($cacheKey)) {
            return session($cacheKey);
        }

        $ruleModel = $user->rule()->where('name', $this->getUri());
        if ($user->manager == 0) {
            $ruleModel->where('isadmin', 0);
        }
        // 再看数据库
        $rule = $ruleModel->find();
        if (empty($rule)) {
            config('session.login_auth') && session($cacheKey, null);
            return false;
        }
        config('session.login_auth') && session($cacheKey, true);
        return true;
    }
}
