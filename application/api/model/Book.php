<?php
namespace app\api\model;

use think\Model;

class Book extends Model
{

    protected $type = [
        'gather' => 'array',
        'types' => 'array',
    ];
    /**
     * 章节
     * @method   chapter
     * @DateTime 2017-06-02T17:04:18+0800
     * @return   [type]                   [description]
     */
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
            ->field(['create_time', 'modify_time', 'alias', 'types', 'gather'], true, 'book')
            ->field(['id', 'name'], false, 'book_chapter', 'bc', 'book_chapter_')
            ->field(['id', 'name'], false, 'tags', 't', 'tag_')
            ->join('tags t', 't.id=a.tags', 'left')
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
            ->join('tags t', 't.id=a.tags', 'left')
            ->field(['id', 'name'], false, 'tags', 't', 'tag_')
            ->field(['id', 'name', 'image', 'remark', 'author_name'], false, 'book');
    }
    /**
     * 搜索书籍
     * @method   scopeSearch
     * @DateTime 2017-05-31T11:55:34+0800
     * @param    [type]                   $query [description]
     * @return   [type]                          [description]
     */
    protected function scopeSearch($query)
    {
        $query->alias('a')
            ->join('tags t', 't.id=a.tags', 'left')
            ->field(['id', 'name'], false, 'tags', 't', 'tag_')
            ->field(['id', 'name', 'image', 'remark', 'author_name'], false, 'book');
    }
    /**
     * 搜索推荐类型的书籍
     * @method   scopeType
     * @DateTime 2017-05-31T12:16:20+0800
     * @param    string                   $value [description]
     * @return   [type]                          [description]
     */
    protected function scopeType($query)
    {
        $query->join('book_type bt', 'bt.book_id=a.id', 'left');
    }

}
