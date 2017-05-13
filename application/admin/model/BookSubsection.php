<?php
namespace app\admin\model;

use think\Model;

class BookSubsection extends Model
{
    protected $updateTime = 'modify_time';

    /**
     * 列表
     * @method   scopeList
     * @DateTime 2017-05-11T15:49:09+0800
     * @param    [type]                   $query [description]
     * @return   [type]                          [description]
     */
    protected function scopeOption($query)
    {
        $query->field('id,name');
    }
}
