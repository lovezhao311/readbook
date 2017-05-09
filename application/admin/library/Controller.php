<?php
namespace app\admin\library;

use app\admin\library\User as UserLibrary;

class Controller extends \luffyzhao\helper\Controller
{
    /**
     * 当前登录用户模型
     * @var null
     */
    protected $userLibrary = null;
    protected function _initialize()
    {
        $this->userLibrary = UserLibrary::instance();

        if (!$this->request->isAjax()) {
            $this->assign('login', $this->userLibrary->getUser());
        }
    }
}
