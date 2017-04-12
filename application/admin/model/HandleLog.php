<?php
namespace app\admin\model;

use app\admin\library\User as UserLibrary;
use think\Model;

class HandleLog extends Model
{
    public function scopeList($query)
    {
        $query->where('user_id', UserLibrary::instance()->getUser()->id)->order('id DESC');
    }
}
