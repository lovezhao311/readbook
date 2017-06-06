<?php
namespace app\api\model;

use think\Model;

class Tags extends Model
{
    /**
     * 关联书籍
     * @method   book
     * @DateTime 2017-06-02T13:44:41+0800
     * @return   [type]                   [description]
     */
    public function book()
    {
        $this->belongsToMany('Book', 'book_tags', 'book_id', 'tags_id')->field(['id', 'name', 'image', 'tags', 'remark', 'author_name'], false, 'book');
    }
    /**
     * 用户组列表
     * @method   scopeList
     * @DateTime 2017-04-06T11:46:49+0800
     * @param    [type]                   $query [description]
     * @return   [type]                          [description]
     */
    protected function scopeList($query)
    {
        $query->field('id,name')->order('id ASC');
    }
}
