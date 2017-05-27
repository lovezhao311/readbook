<?php
namespace app\api\model;

use think\Model;

class BookChapter extends Model
{
    /**
     * 章节列表
     * @method   scopeList
     * @DateTime 2017-05-13T08:47:24+0800
     * @param    [type]                   $query [description]
     * @return   [type]                          [description]
     */
    protected function scopeList($query)
    {
        $query->alias('a')
            ->field(['id', 'name', 'create_time'], false, 'book_chapter')
            ->field(['id', 'name'], false, 'book_subsection', 'bs', 'subsection_')
            ->join('book_subsection bs', 'bs.id=a.subsection_id')
            ->order('bs.sort ASC, bs.id ASC, a.id ASC');
    }

    /**
     * 采集
     * @method   scpoeGather
     * @DateTime 2017-05-11T16:03:00+0800
     * @param    [type]                   $query [description]
     * @return   [type]                          [description]
     */
    protected function scopeShow($query)
    {
        $query->alias('a')
            ->join('book b', 'b.id=a.book_id')
            ->field(['id', 'name', 'status', 'content'], false, 'book_chapter')
            ->field(['gather', 'name', 'id'], false, 'book', 'b', 'book_');
    }
}
