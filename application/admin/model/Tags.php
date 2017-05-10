<?php
namespace app\admin\model;

use think\Model;

class Tags extends Model
{
    protected $updateTime = 'modify_time';
    /**
     * 用户组列表
     * @method   scopeList
     * @DateTime 2017-04-06T11:46:49+0800
     * @param    [type]                   $query [description]
     * @return   [type]                          [description]
     */
    protected function scopeList($query)
    {
        $query->field('id,name,en_name')->order('create_time DESC');
    }
}
