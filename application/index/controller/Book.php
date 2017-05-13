<?php
namespace app\index\controller;

use app\admin\library\Gather as GatherLibrary;
use app\index\model\Book as BookModel;
use app\index\model\BookChapter as BookChapterModel;
use think\Controller;
use think\Exception;

class Book extends Controller
{
    /**
     * 书籍详情
     * @method   index
     * @DateTime 2017-05-13T13:06:07+0800
     * @param    [type]                   $id [description]
     * @return   [type]                       [description]
     */
    public function index($id)
    {
        $book = BookModel::scope('show')->find($id);

        $cacheKey = 'book_chapter_' . $id;
        if (cache('?' . $cacheKey)) {
            $chapters = cache($cacheKey);
        } else {
            $chapters = $book->chapter;
            cache($cacheKey, $chapters);
        }

        $this->assign('book', $book);
        $this->assign('chapters', $chapters);
        return $this->fetch();
    }
    /**
     * 章节
     * @method   chapter
     * @DateTime 2017-05-13T13:06:22+0800
     * @param    [type]                   $bid [description]
     * @param    [type]                   $id  [description]
     * @return   [type]                        [description]
     */
    public function chapter($bid, $id)
    {
        $chapter = BookChapterModel::scope('show')->find($id);
        if (empty($chapter)) {
            $this->error('章节不存在!');
        }
        if ($chapter['status'] == 0) {
            try {
                $gatherLibrary = new GatherLibrary($chapter['id'], json_decode($chapter['book_gather'], true));
                $chapter['content'] = $gatherLibrary->chapter($chapter);
            } catch (Exception $e) {
                $chapter['content'] = '';
            }
        }

        $this->assign('chapter', $chapter);
        return $this->fetch();
    }
}
