<?php
namespace app\api\controller;

use app\admin\library\CheckUpdate;
use app\api\model\Book as BookModel;
use app\api\model\BookChapter as BookChapterModel;
use think\Controller;
use think\Exception;

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
        $data = $this->request->get();

        $query = BookModel::scope('search');

        $where = [];
        // 推荐类型搜索
        if (isset($data['type']) && !empty($data['type'])) {
            $query = BookModel::scope('search,type')->where('bt.type', $data['type']);
        }
        // 连载状态
        if (isset($data['end_status']) && !empty($data['end_status'])) {
            $query->where('a.end_status', $data['end_status']);
        }
        $lists = $query->limit(4)->select();
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
     * 检查是否更新
     * @method   checkupdate
     * @DateTime 2017-06-05T13:57:50+0800
     * @return   [type]                   [description]
     */
    public function checkupdate()
    {
        $id = $this->request->get('id');
        try {
            $check = new CheckUpdate('api');
            $check->check($id);
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
        $this->success('成功');
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
        $chapters = BookChapterModel::scope('list')->where('a.book_id', $id)->select();
        $this->success('成功', '', $chapters);
    }
}
