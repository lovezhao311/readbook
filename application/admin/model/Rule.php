<?php
namespace app\admin\model;

use think\Db;
use think\Model;

class Rule extends Model
{
    protected $auto = ['level'];

    protected $type = [
        'islink' => 'integer',
        'isadmin' => 'integer',
        'isverify' => 'integer',
    ];

    protected $updateTime = 'modify_time';
    /**
     * 上级菜单
     * @method   parent
     * @DateTime 2017-04-01T17:48:29+0800
     * @return   [type]                   [description]
     */
    public function parent()
    {
        return $this->hasOne('rule', 'id', 'parent_id');
    }
    /**
     * 列表页面获取的字段
     * @method   scopeList
     * @DateTime 2017-03-31T16:05:10+0800
     * @param    [type]                   $query [description]
     * @return   [type]                          [description]
     */
    public function scopeList($query)
    {
        $query->field('level,name,title,icon,islink,sort,parent_id,id')->order('parent_id ASC,sort ASC');
    }

    /**
     * 列表页面获取的字段
     * @method   scopeList
     * @DateTime 2017-03-31T16:05:10+0800
     * @param    [type]                   $query [description]
     * @return   [type]                          [description]
     */
    public function scopeLeftmenu($query)
    {
        $query->field('name,title,icon,parent_id,id')->where('level', '<=', 2)->where('islink', 1)->order('parent_id ASC,sort ASC');
    }
    /**
     * 获取所有的权限菜单
     * @method   scopeRule
     * @DateTime 2017-04-07T12:22:47+0800
     * @param    [type]                   $query [description]
     * @return   [type]                          [description]
     */
    public function scopeRule($query)
    {
        $query->field('name,title,icon,parent_id,id,isadmin,isverify')->order('parent_id ASC,sort ASC');
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
        $query->field('level,title,parent_id,id')->where('islink', 1)->order('parent_id ASC,sort ASC');
    }
    /**
     * 分配权限页面获取的字段
     * @method   scopeRole
     * @DateTime 2017-04-05T14:17:19+0800
     * @param    string                   $value [description]
     * @return   [type]                          [description]
     */
    public function scopeRole($query)
    {
        $query->field('isverify,isadmin,title,islink,parent_id,id')->order('parent_id ASC,sort ASC');
    }

    /**
     * url全部设置为小写
     * @method   setNameAttr
     * @DateTime 2017-04-01T15:17:51+0800
     * @param    [type]                   $name [description]
     * @param    [type]                   $data [description]
     */
    protected function setNameAttr($name, $data)
    {
        return strtolower($name);
    }
    /**
     * level设置
     * @method   setLevelAttr
     * @DateTime 2017-04-01T15:38:58+0800
     * @param    [type]                   $name [description]
     * @param    [type]                   $data [description]
     */
    protected function setLevelAttr($name, $data)
    {
        if (isset($data['parent_id']) && $data['parent_id'] > 0) {
            return ((int) Db::name('rule')->where('id', $data['parent_id'])->value('level') + 1);
        }
        return 1;
    }
}
