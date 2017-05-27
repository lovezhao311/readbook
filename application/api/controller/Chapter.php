<?php
namespace app\api\controller;

use app\admin\library\Gather as GatherLibrary;
use app\api\model\BookChapter as BookChapterModel;
use think\Controller;
use think\Exception;

class Chapter extends Controller
{
    /**
     * 书籍详情
     * @method   index
     * @DateTime 2017-05-13T13:06:07+0800
     * @param    [type]                   $id [description]
     * @return   [type]                       [description]
     */
    public function detail()
    {
        set_time_limit(0);
        $data = $this->request->get();

        $query = BookChapterModel::scope('show')->where('b.id', $data['book_id']);
        switch ($data['type']) {
            case 'chapter':
                ($data['id'] != 0) && $query->where('a.id', $data['id']);
                break;
            case 'lastpage':
                $query->where('a.id', '<', $data['id']);
                break;
            case 'nextpage':
                $query->where('a.id', '>', $data['id']);
                break;
        }
        $chapter = $query->find();

        if ($chapter['status'] == 0) {
            try {
                $gatherLibrary = new GatherLibrary($chapter['id'], json_decode($chapter['book_gather'], true));
                $chapter['content'] = $gatherLibrary->chapter($chapter);
            } catch (Exception $e) {
                $chapter['content'] = null;
            }
        }
        unset($chapter['book_gather']);
        $this->success('成功', '', $chapter);
    }

}
