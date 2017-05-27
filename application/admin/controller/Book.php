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
                $this->save($book, [], 'add', $data);
                // 保存tags
                if (isset($data['tags'])) {
                    $tags = array_keys($data['tags']);
                    if (!empty($tags)) {
                        $book->tag()->attach($tags);
                    }
                }
                // 保存推荐类型
                if (!empty($data['types'])) {
                    $types = array_map(function ($value) {
                        return ['type' => $value];
                    }, $data['types']);

                    $book->type()->saveAll($types);
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
                $oldtags = $book->tags;
                $this->save($book, [], 'edit', $data);

                // 删除标签
                $book->tag()->detach();
                // 标签修改
                if (isset($data['tags'])) {
                    $tags = array_keys($data['tags']);
                    $book->tag()->attach($tags);
                }
                // 如果 之前有推荐类型
                $book->type()->delete();
                // 保存推荐类型
                if (!empty($data['types'])) {
                    // 添加
                    $types = array_map(function ($value) {
                        return ['type' => $value];
                    }, $data['types']);

                    $book->type()->saveAll($types);
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

}
