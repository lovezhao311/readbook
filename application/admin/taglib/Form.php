<?php
namespace app\admin\taglib;

use think\template\TagLib;

class Form extends TagLib
{
    // 标签定义
    protected $tags = [
        // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
        'selected' => ['attr' => 'name,id,eq', 'close' => 0],
        'checked' => ['attr' => 'name,id,eq', 'close' => 0],
        'disabled' => ['attr' => 'name,id,eq', 'close' => '0'],
    ];
    /**
     * 表单select输出
     * 在模板中输出selected选中效果
     * 格式： {selected name="" id="" eq=""/}
     * @method   tagSelected
     * @DateTime 2017-03-04T15:02:13+0800
     * @param    [type]                   $tag     [description]
     * @param    [type]                   $content [description]
     * @return   [type]                            [description]
     */
    public function tagSelected($tag, $content)
    {
        $name = $this->autoBuildVar($tag['name']);
        $flag = substr($tag['id'], 0, 1);
        if ('$' == $flag || ':' == $flag) {
            $value = $this->autoBuildVar($tag['id']);
        } else {
            $value = '\'' . $tag['id'] . '\'';
        }
        $eq = isset($tag['eq']) ? $tag['eq'] : '==';

        $parseStr = '<?php echo (isset(' . $name . ') && (' . $name . $eq . $value . ')) ? "selected" : ""; ?>';
        return $parseStr;
    }

    /**
     * 表单checkbox输出
     * 在模板中输出checked选中效果
     * 格式： {checked name="" id="" eq=""/}
     * @method   tagSelected
     * @DateTime 2017-03-04T15:02:13+0800
     * @param    [type]                   $tag     [description]
     * @param    [type]                   $content [description]
     * @return   [type]                            [description]
     */
    public function tagChecked($tag, $content)
    {
        $name = $this->autoBuildVar($tag['name']);
        $flag = substr($tag['id'], 0, 1);
        if ('$' == $flag || ':' == $flag) {
            $value = $this->autoBuildVar($tag['id']);
        } else {
            $value = '\'' . $tag['id'] . '\'';
        }
        $eq = isset($tag['eq']) ? $tag['eq'] : '==';

        switch ($eq) {
            case 'in':
                $parseStr = '<?php echo (isset(' . $name . ') && in_array(' . $name . ',' . $value . ')) ? "checked" : ""; ?>';
                break;
            default:
                $parseStr = '<?php echo (isset(' . $name . ') && (' . $name . $eq . $value . ')) ? "checked" : ""; ?>';
                break;
        }

        return $parseStr;
    }
    /**
     * 是否禁用
     * 格式：{disabled name="" eq="" id="" /}
     * @method   tagDisabled
     * @DateTime 2017-03-07T13:43:57+0800
     * @param    [type]                   $tag     [description]
     * @param    [type]                   $content [description]
     * @return   [type]                            [description]
     */
    public function tagDisabled($tag, $content)
    {
        $name = $this->autoBuildVar($tag['name']);
        $flag = substr($tag['id'], 0, 1);
        if ('$' == $flag || ':' == $flag) {
            $value = $this->autoBuildVar($tag['id']);
        } else {
            $value = '\'' . $tag['id'] . '\'';
        }
        $eq = isset($tag['eq']) ? $tag['eq'] : '==';

        $parseStr = '<?php echo (isset(' . $name . ') && (' . $name . $eq . $value . ')) ? "disabled" : ""; ?>';
        return $parseStr;
    }
}
