<?php
namespace app\admin\model;

use think\Model;

class Rule extends Model
{
    protected $updateTime = 'modify_time';
    /**
     * 列表页面获取的字段
     * @method   scopeList
     * @DateTime 2017-03-31T16:05:10+0800
     * @param    [type]                   $query [description]
     * @return   [type]                          [description]
     */
    public function scopeList($query)
    {
        $query->field('level,name,title,icon,islink,sort,parent_id,id')->order('parent_id ASC');
    }
    /**
     * select 选择框数据
     * @method   scopeOption
     * @DateTime 2017-03-31T16:44:23+0800
     * @param    [type]                   $query [description]
     * @return   [type]                          [description]
     */
    public function scopeSelect($query)
    {
        $query->field('level,title,parent_id,id')->where('islink', 1)->order('parent_id ASC');
    }
}
