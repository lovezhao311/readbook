<?php
namespace app\admin\model;

use think\Model;

class BookChapter extends Model
{
    protected $updateTime = 'modify_time';

    /**
     * 关联书籍
     * @method   tags
     * @DateTime 2017-05-10T12:03:53+0800
     * @return   [type]                   [description]
     */
    public function book()
    {
        return $this->belongsTo('Book', 'book_id', 'id');
    }
    /**
     * 列表
     * @method   scopeList
     * @DateTime 2017-05-11T15:49:09+0800
     * @param    [type]                   $query [description]
     * @return   [type]                          [description]
     */
    protected function scopeList($query)
    {
        $query->alias('a')
            ->field(['id', 'name', 'word_count', 'status', 'error', 'create_time'], false, 'book_chapter')
            ->field(['id', 'name'], false, 'book_subsection', 'bs', 'subsection_')
            ->join('book_subsection bs', 'bs.id=a.subsection_id')
            ->order('bs.sort ASC, bs.id ASC');
    }
    /**
     * 采集
     * @method   scpoeGather
     * @DateTime 2017-05-11T16:03:00+0800
     * @param    [type]                   $query [description]
     * @return   [type]                          [description]
     */
    protected function scopeGather($query)
    {
        $query->alias('a')
            ->join('book b', 'b.id=a.book_id')
            ->field(['id', 'name'], false, 'book_chapter')
            ->field(['id', 'gather', 'name'], false, 'book', 'b', 'book_')
            ->where('status', 0);
    }
}
