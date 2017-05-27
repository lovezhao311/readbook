<?php
namespace app\api\controller;

use app\api\model\Book as BookModel;
use app\api\model\BookChapter as BookChapterModel;
use think\Controller;

class Book extends Controller
{
    /**
     * 书籍列表
     * @method   index
     * @DateTime 2017-05-26T18:01:10+0800
     * @return   [type]                   [description]
     */
    public function index()
    {
        $lists = BookModel::scope('list')->limit(4)->select();
        $this->result($lists, 1);
    }
    /**
     * 书籍详情
     * @method   index
     * @DateTime 2017-05-13T13:06:07+0800
     * @param    [type]                   $id [description]
     * @return   [type]                       [description]
     */
    public function detail()
    {
        $id = $this->request->get('id');
        $book = BookModel::scope('show')->find($id);
        $this->success('成功', '', $book);
    }
    /**
     * 章节
     * @method   chapter
     * @DateTime 2017-05-13T13:06:22+0800
     * @param    [type]                   $bid [description]
     * @param    [type]                   $id  [description]
     * @return   [type]                        [description]
     */
    public function chapter()
    {
        $id = $this->request->get('id');
        $chapters = BookChapterModel::scope('list')->where('a.book_id', $id)->paginate(100);
        $this->success('成功', '', $chapters);
    }
}
