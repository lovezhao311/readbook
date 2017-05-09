<?php
namespace app\admin\controller;

use app\admin\library\Controller;
use app\admin\model\Source as SourceModel;
use think\Exception;

class Source extends Controller
{
    /**
     * 来源
     * @method   index
     * @DateTime 2017-03-31T13:36:08+0800
     * @return   [type]                   [description]
     */
    public function index()
    {
        if ($this->request->isAjax()) {
            $model = SourceModel::scope('list');
            $list = $this->search($model)->paginate();
            $this->result($list->toArray(), 1);
        }
        return $this->fetch();
    }
    /**
     * 添加来源
     * @method   add
     * @DateTime 2017-03-31T16:39:49+0800
     * @param    string                   $value [description]
     */
    public function add()
    {
        if ($this->request->isAjax()) {
            try {
                $source = new SourceModel;
                $this->save($source);
            } catch (Exception $e) {
                $this->error($e->getMessage());
            }
            $this->success('添加来源[id:' . $source->id . ']', 'index');
        }
        return $this->fetch();
    }
    /**
     * 修改来源
     * @method   edit
     * @DateTime 2017-04-01T16:14:17+0800
     * @param    [type]                   $id [description]
     * @return   [type]                       [description]
     */
    public function edit($id)
    {
        $source = SourceModel::get($id);
        if (empty($source)) {
            $this->error('来源不存在！');
        }

        if ($this->request->isAjax()) {
            try {
                $this->save($source, ['id' => $id], 'edit');
            } catch (Exception $e) {
                $this->error($e->getMessage());
            }
            $this->success('修改来源[id:' . $source->id . ']', 'index');
        }

        $this->assign('source', $source);
        return $this->fetch();
    }
    /**
     * 销毁来源
     * @method   destroy
     * @DateTime 2017-04-05T14:09:43+0800
     * @param    [type]                   $id [description]
     * @return   [type]                       [description]
     */
    public function destroy($id)
    {
        if ($this->request->isAjax()) {
            $source = new SourceModel;
            try {
                $this->delete($source, ['id' => $id]);
            } catch (Exception $e) {
                $this->error($e->getMessage());
            }
            $this->success('删除来源[id:' . $id . ']');
        }
    }

}
