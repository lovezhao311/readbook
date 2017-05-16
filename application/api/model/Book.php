<?php
namespace app\api\model;

use think\Model;

class Book extends Model
{

    public function chapter()
    {
        return $this->hasMany('BookChapter', 'a.book_id', 'id')
            ->alias('a')
            ->field(['id', 'name', 'word_count'], false, 'book_chapter')
            ->field(['id', 'name'], false, 'book_subsection', 'bs', 'subsection_')
            ->join('book_subsection bs', 'bs.id=a.subsection_id')
            ->order('bs.sort ASC, bs.id ASC, a.id ASC');
    }
    /**
     * 详情
     * @method   scopeShow
     * @DateTime 2017-05-13T08:34:09+0800
     * @param    [type]                   $query [description]
     * @return   [type]                          [description]
     */
    protected function scopeShow($query)
    {
        $query->alias('a')
            ->field(['create_time', 'modify_time', 'gather'], true, 'book')
            ->field(['id', 'name'], false, 'author', 'au', 'author_')
            ->field(['id', 'name'], false, 'source', 'so', 'source_')
            ->field(['id', 'name'], false, 'book_chapter', 'bc', 'book_chapter_')
            ->join('author au', 'au.id=a.author_id', 'left')
            ->join('source so', 'so.id=a.source_id', 'left')
            ->join('book_chapter bc', 'bc.id=a.last_chapter_id', 'left');
    }
    /**
     * 列表页面
     * @method   scopeList
     * @DateTime 2017-05-10T15:03:52+0800
     * @param    [type]                   $query [description]
     * @return   [type]                          [description]
     */
    protected function scopeList($query)
    {
        $query->alias('a')
            ->field(['id', 'name', 'isbn', 'end_status', 'image', 'modify_time'], false, 'book')
            ->field(['name'], false, 'author', 'au', 'author_')
            ->field(['id', 'name'], false, 'book_chapter', 'bc', 'book_chapter_')
            ->join('author au', 'au.id=a.author_id', 'left')
            ->join('book_chapter bc', 'bc.id=a.last_chapter_id', 'left');
    }
}
