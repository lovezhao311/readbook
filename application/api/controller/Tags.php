<?php
namespace app\api\controller;

use app\api\model\Book as BookModel;
use app\api\model\Tags as TagsModel;
use think\Controller;

/**
 *
 */
class Tags extends Controller
{
    /**
     * 标签tags
     * @method   list
     * @DateTime 2017-06-02T12:13:49+0800
     * @return   [type]                   [description]
     */
    function list() {
        $lists = TagsModel::scope('list')->select();
        $this->result($lists, 1);
    }
    /**
     * 标签书籍
     * @method   detail
     * @DateTime 2017-06-02T13:43:05+0800
     * @param    [type]                   $id [description]
     * @return   [type]                       [description]
     */
    public function detail()
    {
        $id = $this->request->get('id', 0);
        if ($id > 0) {
            $query = BookModel::scope('list')->where('a.tags', $id);
        } else {
            $query = BookModel::scope('list');
        }
        $lists = $query->paginate();
        $this->result($lists, 1);
    }
}
