<?php
namespace app\admin\controller;

use app\admin\library\Controller;
use app\admin\model\Author as AuthorModel;
use think\Exception;

class Author extends Controller
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
            $model = AuthorModel::scope('list');
            $list = $this->search($model)->paginate();
            $this->result($list->toArray(), 1);
        }
        return $this->fetch();
    }
    /**
     * 添加作者
     * @method   add
     * @DateTime 2017-03-31T16:39:49+0800
     * @param    string                   $value [description]
     */
    public function add()
    {
        if ($this->request->isAjax()) {
            try {
                $author = new AuthorModel;
                $this->save($author);
            } catch (Exception $e) {
                $this->error($e->getMessage());
            }
            $this->success('添加书籍作者[id:' . $author->id . ']', 'index');
        }
        return $this->fetch();
    }
    /**
     * 修改作者
     * @method   edit
     * @DateTime 2017-04-01T16:14:17+0800
     * @param    [type]                   $id [description]
     * @return   [type]                       [description]
     */
    public function edit($id)
    {
        $author = AuthorModel::get($id);
        if (empty($author)) {
            $this->error('书籍作者不存在！');
        }
        if ($this->request->isAjax()) {
            try {
                $this->save($author, ['id' => $id], 'edit');
            } catch (Exception $e) {
                $this->error($e->getMessage());
            }
            $this->success('修改书籍作者[id:' . $author->id . ']', 'index');
        }
        $this->assign('author', $author);
        return $this->fetch();
    }
    /**
     * 销毁作者
     * @method   destroy
     * @DateTime 2017-04-05T14:09:43+0800
     * @param    [type]                   $id [description]
     * @return   [type]                       [description]
     */
    public function destroy($id)
    {
        $author = new AuthorModel;
        try {
            $this->delete($author, ['id' => $id]);
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
        $this->success('删除书籍作者[id:' . $id . ']');
    }

}
