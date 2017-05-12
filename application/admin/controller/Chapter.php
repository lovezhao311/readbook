<?php
namespace app\admin\controller;

use app\admin\library\Controller;
use app\admin\library\Gather as GatherLibrary;
use app\admin\model\Book as BookModel;
use app\admin\model\BookChapter as BookChapterModel;
use think\Exception;

class Chapter extends Controller
{
    /**
     * 章节
     * @method   index
     * @DateTime 2017-03-31T13:36:08+0800
     * @return   [type]                   [description]
     */
    public function index($id)
    {
        $book = BookModel::get($id);
        if (empty($book)) {
            $this->error('书籍不存在！');
        }
        if ($this->request->isAjax()) {
            $model = BookChapterModel::scope('list')->where('book_id', $id);
            $list = $this->search($model)->paginate();
            $this->result($list->toArray(), 1);
        }

        $this->assign('book', $book);
        return $this->fetch();
    }
    /**
     * 采集
     * @method   add
     * @DateTime 2017-03-31T16:39:49+0800
     * @param    string                   $value [description]
     */
    public function gather($id)
    {
        $chapter = BookChapterModel::scope('gather')->find($id);
        if (empty($chapter)) {
            $this->error('章节不存在,或者已采集!');
        }
        try {
            $gatherLibrary = new GatherLibrary($chapter['id'], json_decode($chapter['book_gather'], true));
            $gatherLibrary->chapter($chapter);
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
        $this->success('采集');
    }
    /**
     * 修改章节
     * @method   edit
     * @DateTime 2017-04-01T16:14:17+0800
     * @param    [type]                   $id [description]
     * @return   [type]                       [description]
     */
    public function edit($id)
    {
        $chapter = BookChapterModel::get($id);
        if (empty($chapter)) {
            $this->error('章节不存在！');
        }

        if ($this->request->isAjax()) {
            try {
                $this->save($chapter, ['id' => $id], 'edit');
            } catch (Exception $e) {
                $this->error($e->getMessage());
            }
            $this->success('修改章节[id:' . $chapter->id . ']');
        }

        $this->assign('chapter', $chapter);
        return $this->fetch();
    }
}
