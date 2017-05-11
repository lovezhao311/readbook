<?php
namespace app\admin\library;

use think\Db;
use think\Exception;

class Gather
{
    /**
     * 书籍ID
     * @var null
     */
    protected $bookId = null;
    /**
     * 规则
     * @var array
     */
    protected $rule = [];
    /**
     * 构造函数
     * @method   __construct
     * @DateTime 2017-05-11T16:15:26+0800
     * @param    [type]                   $id   书籍ID
     * @param    [type]                   $rule 采集规则
     */
    public function __construct(int $id, array $rule)
    {
        $this->bookId = $id;
        if (!empty($rule)) {
            $this->rule = $rule[array_rand($rule)];
        } else {
            throw new Exception('采集配置不存在！');
        }
    }
    /**
     * 通过章节标题采集章节
     * @method   chapter
     * @DateTime 2017-05-11T16:17:31+0800
     * @param    [type]                   $title 章节标题
     * @return   [type]                          [description]
     */
    public function chapter($title)
    {
        $gather = $this->getGather();
        $chapterDom = $this->load();

        $lists = $chapterDom->find($gather['list']);

        $href = '';
        foreach ($lists as $list) {
            if ($this->contain($title, $list->getPlainText())) {
                $href = $list->getAttr('href');
            }
        }

        if (empty($href)) {
            throw new Exception('未采集到该章节！');
        }

        $chapterUrl = $this->montageUrl($href);

        return $chapterUrl;
    }

    /**
     * 拼接URL
     * @method   montageUrl
     * @DateTime 2017-05-11T16:49:07+0800
     * @param    [type]                   $local  [description]
     * @param    [type]                   $append [description]
     * @return   [type]                           [description]
     */
    protected function montageUrl($append)
    {
        if (substr($append, 0, 1) == '/') {
            $append = substr($append, 1);
            $local = $this->getHost($this->rule['list_url']);
        } else {
            $local = $this->getHost($this->rule['list_url'], false);
        }

        return $local . $append;
    }
    /**
     * 获取URL 的host
     * @method   getHost
     * @DateTime 2017-05-11T16:53:01+0800
     * @param    [type]                   $url [description]
     * @return   [type]                        [description]
     */
    protected function getHost($url, $path = false)
    {
        $hosts = new Uri($url);
        return $hosts->getScheme() . '://' . $hosts->getHost() . ($path == true ? $hosts->getPath() : '') . '/';
    }
    /**
     * 匹配标题
     * @method   contain
     * @DateTime 2017-05-11T16:43:00+0800
     * @param    [type]                   $title [description]
     * @param    [type]                   $text  [description]
     * @return   [type]                          [description]
     */
    protected function contain($title, $text)
    {
        if ($title == $text) {
            return true;
        }
        $title = str_ireplace('（', ' ', $title);
        $title = str_ireplace('）', ' ', $title);
        if ($title == $text) {
            return true;
        }
        return false;
    }
    /**
     * 获取采集配置
     * @method   getGather
     * @DateTime 2017-05-11T16:36:29+0800
     * @return   [type]                   [description]
     */
    protected function getGather()
    {
        return Db::name('gather')->find($this->rule['gather_id']);
    }
    /**
     * 获取文件 本地&远程
     * @author luffy<luffyzhao@vip.126.com>
     * @dateTime 2016-04-15T15:21:35+0800
     * @param    [type]                   $url [description]
     * @return   [type]                        [description]
     */
    protected function load()
    {
        $html = file_get_contents($this->rule['list_url']);
        return new ParserDom($html);
    }
}
