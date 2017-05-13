<?php
namespace app\index\model;

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
        $query->field(['id', 'name', 'word_count', 'group'])->order('create_time');
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
            ->field(['id', 'gather', 'name'], false, 'book', 'b', 'book_');
    }
}
