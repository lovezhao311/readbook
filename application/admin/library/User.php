<?php
namespace app\admin\library;

use app\admin\model\Rule;
use app\admin\model\User as UserModel;
use think\Exception;

/**
 * 后台用户操作类
 */
class User
{
    /**
     * @var object 对象实例
     */
    protected static $instance;

    protected $_user = null;

    /**
     * 初始化
     * @access public
     * @param array $options 参数
     * @return \think\Request
     */
    public static function instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new static();
        }
        return self::$instance;
    }
    /**
     * 获取用户信息
     * @method   getUser
     * @DateTime 2017-03-31T11:21:52+0800
     * @return   [type]                   [description]
     */
    public function getUser()
    {
        return $this->_user;
    }
    /**
     * 获取菜单
     * @method   menu
     * @DateTime 2017-04-01T18:00:20+0800
     * @return   [type]                   [description]
     */
    public function getMenu()
    {
        $rule = $this->_user->rule();
        if ($rule == null) {
            $rules = Rule::scope('leftmenu')->select();
        } else {
            $rule->field('name,title,icon,parent_id,id')
                ->where('level', '<=', 2)
                ->where('islink', 1)
                ->order('parent_id ASC,sort ASC');
            if ($this->_user->manager == 0) {
                $rule->where('isadmin', 0);
            }
            $rules = $rule->select();
        }
        return collection($rules)->toArray();
    }
    /**
     * 获取当前用户组权限
     * @method   getRule
     * @DateTime 2017-04-07T12:22:11+0800
     * @return   [type]                   [description]
     */
    public function getRule()
    {
        $rule = $this->_user->rule();
        if ($rule == null) {
            $rules = Rule::scope('rule')->select();
        } else {
            $rules = $rule->field('name,title,icon,parent_id,id,isverify,isadmin')
                ->order('parent_id ASC,sort ASC')
                ->select();
        }
        return $rules;
    }
    /**
     * 用户登录
     * @method   login
     * @DateTime 2017-03-31T11:47:50+0800
     * @return   [type]                   [description]
     */
    public function login()
    {
        //  用户已登录不再做登录操作
        if ($this->_user !== null) {
            return $this->_user;
        }
        $login = request()->post('data/a');

        $user = UserModel::where('email', $login['email'])->find();
        if (empty($user)) {
            throw new Exception("登录失败,用户不存在！");
        }
        if ($user['status'] == 0) {
            throw new Exception("登录失败,用户不存在！");
        }
        $password = $user->setPasswordAttr($login['password']);

        if ($password != $user['password']) {
            throw new Exception("登录失败,密码不正确！");
        }
        $user->last_ip = request()->ip();
        $user->last_time = date('Y-m-d H:i:s');
        $user->save();
        // 设置session
        session(config('session.login'), serialize($user));
        $this->_user = $user;
    }
    /**
     * 私有构造函数，防止外界实例化对象
     * @method   __construct
     * @DateTime 2017-03-31T11:19:33+0800
     */
    private function __construct()
    {
        $userSerialize = session(config('session.login'));
        $user = unserialize($userSerialize);
        if (!($user instanceof \think\Model)) {
            $this->_user = null;
            return false;
        }
        $this->_user = $user;
    }
    /**
     * 私有克隆函数，防止外办克隆对象
     * @method   __clone
     * @DateTime 2017-03-31T11:19:39+0800
     * @return   [type]                   [description]
     */
    private function __clone()
    {
    }
}
