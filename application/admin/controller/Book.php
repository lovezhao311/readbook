<?php
namespace app\admin\controller;

use app\admin\library\Controller;
use app\admin\model\Author as AuthorModel;
use app\admin\model\Book as BookModel;
use app\admin\model\Gather as GatherModel;
use app\admin\model\Source as SourceModel;
use think\Db;
use think\Exception;

class Book extends Controller
{
    /**
     * 书籍
     * @method   index
     * @DateTime 2017-03-31T13:36:08+0800
     * @return   [type]                   [description]
     */
    public function index()
    {
        if ($this->request->isAjax()) {
            $model = BookModel::scope('list');
            $list = $this->search($model)->paginate();
            $this->result($list->toArray(), 1);
        }
        return $this->fetch();
    }
    /**
     * 添加书籍
     * @method   add
     * @DateTime 2017-03-31T16:39:49+0800
     * @param    string                   $value [description]
     */
    public function add()
    {
        if ($this->request->isAjax()) {
            $data = $this->request->post('data/a');
            Db::startTrans();
            try {
                $book = new BookModel;
                $data['gather'] = $this->setGather($data['gather']);
                $this->save($book, [], 'add', $data);
                // 添加现在的数据
                if (isset($data['tags'])) {
                    $tags = array_values($data['tags']);
                    if (!empty($tags)) {
                        $book->tags()->attach($tags);
                    }
                }
                Db::commit();
            } catch (Exception $e) {
                Db::rollback();
                $this->error($e->getMessage());
            }
            $this->success('添加书籍[id:' . $book->id . ']', 'index');
        }
        $this->assign('gathers', GatherModel::all());
        $this->assign('authors', AuthorModel::all());
        $this->assign('sources', SourceModel::all());
        return $this->fetch();
    }
    /**
     * 修改书籍
     * @method   edit
     * @DateTime 2017-04-01T16:14:17+0800
     * @param    [type]                   $id [description]
     * @return   [type]                       [description]
     */
    public function edit($id)
    {
        $book = BookModel::get($id);
        if (empty($book)) {
            $this->error('书籍不存在！');
        }

        if ($this->request->isAjax()) {
            $data = $this->request->post('data/a');
            Db::startTrans();
            try {

                $data['gather'] = $this->setGather($data['gather']);
                $this->save($book, [], 'edit', $data);
                // 标签修改
                if (isset($data['tags'])) {
                    $oldtags = collection($book->tags()->column('tags.id'))->column('id');
                    $tags = array_values($data['tags']);
                    $deltags = array_values(array_diff($oldtags, $tags));
                    // 删除标签书籍数据
                    if (!empty($deltags)) {
                        $book->tags()->detach($deltags);
                    }
                    $addtags = array_values(array_diff($tags, $oldtags));
                    // 添加现在的数据
                    if (!empty($addtags)) {
                        $book->tags()->attach($addtags);
                    }
                } else {
                    $book->tags()->detach();
                }

                Db::commit();
            } catch (Exception $e) {
                Db::rollback();
                throw $e;

                $this->error($e->getMessage());
            }
            $this->success('修改书籍[id:' . $book->id . ']', 'index');
        }

        $this->assign('book', $book);
        $this->assign('gathers', GatherModel::all());
        $this->assign('authors', AuthorModel::all());
        $this->assign('sources', SourceModel::all());
        return $this->fetch();
    }
    /**
     * 销毁用户组
     * @method   destroy
     * @DateTime 2017-04-05T14:09:43+0800
     * @param    [type]                   $id [description]
     * @return   [type]                       [description]
     */
    public function destroy($id)
    {
        $book = new BookModel;
        try {
            $this->delete($book, ['id' => $id]);
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
        $this->success('删除书籍[id:' . $id . ']');
    }

    /**
     * 采集源数据处理
     * @method   setGatherAtt
     * @DateTime 2017-05-10T11:55:55+0800
     */
    protected function setGather($gather)
    {
        $array = [];
        if (empty($gather['gather_id'])) {
            return $array;
        }
        foreach ($gather['gather_id'] as $key => $value) {
            $array[$value]['gather_id'] = $value;
            $array[$value]['list_url'] = $gather['list_url'][$key];
            $array[$value]['sort'] = $gather['sort'][$key];
        }
        return $array;
    }

}
