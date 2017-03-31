<?php
namespace app\admin\validate;

use think\Validate;

class Rule extends Validate
{
    use \app\admin\library\traits\Validate;

    protected $rule = [
        'parent_id|上级菜单' => ['require', 'exist:rule'],
        'title|菜单标题' => ['require', 'rulename'],
        'name|菜单标题' => ['require', 'name'],
    ];

    protected $message = [
        'parent_id.rule' => '上级菜单不存在！',
        'title.title' => '菜单标题格式错误',
        'title.title' => '菜单标题格式错误',
        'title.title' => '菜单标题格式错误',
    ];

    protected $scene = [
        'add' => ['parent_id', 'name', 'title', 'islink', 'isadmin', 'icon', 'sort'],
    ];
    /**
     * 菜单标题
     * @method   rulename
     * @DateTime 2017-03-31T17:56:17+0800
     * @param    [type]                   $value [description]
     * @param    [type]                   $rule  [description]
     * @return   [type]                          [description]
     */
    protected function rulename($value, $rule)
    {

    }
}
