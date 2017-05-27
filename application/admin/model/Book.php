<?php
namespace app\admin\model;

use think\Model;

class Book extends Model
{
    protected $updateTime = 'modify_time';

    protected $type = [
        'gather' => 'array',
        'tags' => 'array',
        'types' => 'array',
    ];
    /**
     * 关联标签
     * @method   tags
     * @DateTime 2017-05-10T12:03:53+0800
     * @return   [type]                   [description]
     */
    public function tag()
    {
        return $this->belongsToMany('Tags', 'book_tags');
    }
    /**
     * 推荐
     * @method   type
     * @DateTime 2017-05-27T11:29:39+0800
     * @return   [type]                   [description]
     */
    public function type()
    {
        return $this->hasMany('BookType', 'book_id', 'id');
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
            ->field(['id', 'name', 'isbn', 'end_status'], false, 'book')
            ->field(['name'], false, 'author', 'au', 'author_')
            ->field(['name'], false, 'source', 'so', 'source_')
            ->join('author au', 'au.id=a.author_id', 'left')
            ->join('source so', 'so.id=a.source_id', 'left');
    }

}
