<?php
namespace app\admin\controller;

use app\admin\library\Controller;
use app\admin\model\Tags as TagsModel;
use think\Exception;

class Tags extends Controller
{
    /**
     * 书籍标签
     * @method   index
     * @DateTime 2017-03-31T13:36:08+0800
     * @return   [type]                   [description]
     */
    public function index()
    {
        if ($this->request->isAjax()) {
            $model = TagsModel::scope('list');
            $list = $this->search($model)->paginate();
            $this->result($list->toArray(), 1);
        }
        return $this->fetch();
    }
    /**
     * 添加标签
     * @method   add
     * @DateTime 2017-03-31T16:39:49+0800
     * @param    string                   $value [description]
     */
    public function add()
    {
        if ($this->request->isAjax()) {
            try {
                $tags = new TagsModel;
                $this->save($tags);
            } catch (Exception $e) {
                $this->error($e->getMessage());
            }
            $this->success('添加书籍标签[id:' . $tags->id . ']', 'index');
        }
        return $this->fetch();
    }
    /**
     * 修改标签
     * @method   edit
     * @DateTime 2017-04-01T16:14:17+0800
     * @param    [type]                   $id [description]
     * @return   [type]                       [description]
     */
    public function edit($id)
    {
        $tags = TagsModel::get($id);
        if (empty($tags)) {
            $this->error('书籍标签不存在！');
        }

        if ($this->request->isAjax()) {
            try {
                $this->save($tags, ['id' => $id], 'edit');
            } catch (Exception $e) {
                $this->error($e->getMessage());
            }
            $this->success('修改书籍标签[id:' . $tags->id . ']', 'index');
        }

        $this->assign('tags', $tags);
        return $this->fetch();
    }

    /**
     * iframe选择书籍标签
     * @method   index
     * @DateTime 2017-03-31T13:36:08+0800
     * @return   [type]                   [description]
     */
    public function iframe()
    {
        $ids = $this->request->get('params');

        if ($this->request->isAjax()) {
            $model = TagsModel::scope('list');

            $idArr = explode(',', $ids);
            if (!empty($idArr)) {
                $model = $model->where('id', 'not in', $idArr);
            }
            $list = $this->search($model)->paginate();
            $this->result($list->toArray(), 1);
        }

        $this->assign('params', $ids);
        return $this->fetch();
    }
    /**
     * 销毁标签
     * @method   destroy
     * @DateTime 2017-04-05T14:09:43+0800
     * @param    [type]                   $id [description]
     * @return   [type]                       [description]
     */
    public function destroy($id)
    {
        if ($this->request->isAjax()) {
            $tags = new TagsModel;
            try {
                $this->delete($tags, ['id' => $id]);
            } catch (Exception $e) {
                $this->error($e->getMessage());
            }
            $this->success('删除书籍标签[id:' . $id . ']');
        }
    }

}
