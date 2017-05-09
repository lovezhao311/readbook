<?php
namespace app\admin\behavior;

use app\admin\library\User;
use luffyzhao\helper\HandleLog;

class Log
{
    public function run($msg)
    {
        $data = [
            'user_id' => User::instance()->getUser()->id,
            'route' => strtolower(request()->controller()) . '/' . strtolower(request()->action()),
            'msg' => $msg,
            'params' => request()->param(),
        ];
        //
        try {
            HandleLog::instance()->save($data);
        } catch (\Exception $e) {
            Log::record('[ ERR ] 日志插入失败！', 'notice');
        }

    }
}
