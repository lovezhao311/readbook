<?php
namespace app\api\controller;

use app\api\model\Book;
use think\Controller;

/**
 *
 */
class Index extends Controller
{
    /**
     * 首页书籍列表
     * @method   books
     * @DateTime 2017-05-16T17:24:48+0800
     * @return   [type]                   [description]
     */
    public function books()
    {
        $books = Book::scope('list')->paginate();
        $this->success('成功', '', $books);
    }
    /**
     * 轮播图片
     * @method   carousel
     * @DateTime 2017-05-16T17:24:33+0800
     * @return   [type]                   [description]
     */
    public function carousel()
    {
        # code...
    }
}
