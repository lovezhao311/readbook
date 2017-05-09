<?php
namespace app\admin\controller;

use app\admin\library\Controller;
use app\admin\model\Gather as GatherModel;
use think\Exception;

class Gather extends Controller
{
    /**
     * 采集源
     * @method   index
     * @DateTime 2017-03-31T13:36:08+0800
     * @return   [type]                   [description]
     */
    public function index()
    {
        if ($this->request->isAjax()) {
            $model = GatherModel::scope('list');
            $list = $this->search($model)->paginate();
            $this->result($list->toArray(), 1);
        }
        return $this->fetch();
    }
    /**
     * 添加采集源
     * @method   add
     * @DateTime 2017-03-31T16:39:49+0800
     * @param    string                   $value [description]
     */
    public function add()
    {
        if ($this->request->isAjax()) {
            try {
                $gather = new GatherModel;
                $data = $this->request->post('data/a');
                if (isset($data['replace'])) {
                    $data['replace'] = $this->replace($data['replace']);
                }
                $this->save($gather, [], 'add', $data);
            } catch (Exception $e) {
                $this->error($e->getMessage());
            }
            $this->success('添加采集源[id:' . $gather->id . ']', 'index');
        }
        return $this->fetch();
    }
    /**
     * 修改采集源
     * @method   edit
     * @DateTime 2017-04-01T16:14:17+0800
     * @param    [type]                   $id [description]
     * @return   [type]                       [description]
     */
    public function edit($id)
    {
        $gather = GatherModel::get($id);
        if (empty($gather)) {
            $this->error('采集源不存在！');
        }
        if ($this->request->isAjax()) {
            try {
                $data = $this->request->post('data/a');
                if (isset($data['replace'])) {
                    $data['replace'] = $this->replace($data['replace']);
                }
                $this->save($gather, ['id' => $id], 'edit', $data);
            } catch (Exception $e) {
                $this->error($e->getMessage());
            }
            $this->success('修改采集源[id:' . $gather->id . ']', 'index');
        }
        $this->assign('gather', $gather);
        return $this->fetch();
    }
    /**
     * 销毁采集源
     * @method   destroy
     * @DateTime 2017-04-05T14:09:43+0800
     * @param    [type]                   $id [description]
     * @return   [type]                       [description]
     */
    public function destroy($id)
    {
        if ($this->request->isAjax()) {
            $gather = new GatherModel;
            try {
                $this->delete($gather, ['id' => $id]);
            } catch (Exception $e) {
                $this->error($e->getMessage());
            }
            $this->success('删除采集源[id:' . $id . ']');
        }
    }

    /**
     * 内容替换处理
     * @method   replace
     * @DateTime 2017-05-09T11:31:26+0800
     * @param    [type]                   $data [description]
     * @return   [type]                         [description]
     */
    protected function replace($data)
    {
        if (empty($data['search']) || empty($data['replace'])) {
            return [];
        }
        $arr = [];
        foreach ($data['search'] as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $arr[$key]['search'] = $value;
            $arr[$key]['replace'] = $data['replace'][$key];
        }
        return $arr;
    }

}
