<?php
namespace app\admin\library;

use think\Exception;

class Controller extends \think\Controller
{
    protected function _initialize()
    {
    }
    /**
     * 重写控制器验证
     * @method   validate
     * @DateTime 2017-03-31T12:22:20+0800
     * @param    array                    $data  [description]
     * @param    string                   $scene [description]
     * @return   [type]                          [description]
     */
    protected function validate($data = [], $scene = 'add', $message = [], $batch = false, $callback = null)
    {
        $data = array_merge($this->request->post('data/a', []), $data);
        $scene = $this->request->controller() . '.' . $scene;
        $this->validateFailException();
        parent::validate($data, $scene, $message, $batch, $callback);
    }

    /**
     * 保存数据
     * 有 where 条件是更新
     * 没 where 条件是修改
     * @method   save
     * @DateTime 2017-03-04T09:26:12+0800
     * @param    [type]                   $query   更新模型
     * @param    array                    $where    更新条件
     * @return   [type]                            [description]
     */
    protected function save($query, $where = [], $scene = 'add')
    {
        if (!($query instanceof \think\Model)) {
            throw new Exception("保存失败！");
        }
        // 验证数据
        $this->validate([], $scene);

        if ($query->allowField(true)->save($data, $where) === false) {
            $error = $query->getError() ?: '操作失败，请刷新页面重试！';
            throw new Exception($error);
        }

        return $query;
    }
}
