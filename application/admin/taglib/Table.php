<?php
namespace app\admin\taglib;

use think\template\TagLib;

class Table extends TagLib
{
    // 标签定义
    protected $tags = [
        // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
        'status' => ['attr' => 'name', 'close' => 0],
    ];

    /**
     * 是否启用模板输出
     * 格式： {status id="1" /}
     * @method   tagStatus
     * @DateTime 2017-03-04T15:02:13+0800
     * @param    [type]                   $tag     [description]
     * @param    [type]                   $content [description]
     * @return   [type]                            [description]
     */
    public function tagStatus($tag, $content)
    {
        $name = $this->autoBuildVar($tag['name']);

        $parseStr = "<?php echo ($name == 1) ? '<i class=\"layui-icon\" style=\"font-size:24px; color: green;\">&#xe616;</i>' : '<i class=\"layui-icon\" style=\"font-size:24px; color: red;\">&#x1007;</i>';?>";

        return $parseStr;
    }

}
