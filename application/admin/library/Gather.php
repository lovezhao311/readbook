<?php
namespace app\admin\library;

use app\admin\model\BookChapter as BookChapterModel;
use app\admin\model\Gather as GatherModel;
use think\Exception;
use think\Model;

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
     * 通过章节信息采集章节内容
     * @method   chapter
     * @DateTime 2017-05-12T10:19:39+0800
     * @param    [type]                   $bookChapter [description]
     * @return   [type]                                [description]
     */
    public function chapter(Model $bookChapter)
    {
        $gather = $this->getGather();
        $bookDom = $this->load($this->rule['list_url']);
        $lists = $bookDom->find($gather['list']);
        $title = $this->title($bookChapter['name'], $gather['title']);

        $href = '';
        if (!empty($lists)) {
            foreach ($lists as $list) {
                if ($title == $list->getPlainText()) {
                    $href = $list->href;
                }
            }
        }

        if (empty($href)) {
            throw new Exception('未采集到该章节！');
        }

        $content = $this->getContent($href, $gather);
        if ($content == null) {
            throw new Exception('采集失败！');
        }

        $this->updateChapter($bookChapter, $content);
        return $content;
    }
    /**
     * 更新章节
     * @method   updateChapter
     * @DateTime 2017-05-12T10:21:07+0800
     * @param    [type]                   $bookChapter [description]
     * @param    [type]                   $content     [description]
     * @return   [type]                                [description]
     */
    protected function updateChapter($bookChapter, $content)
    {
        return BookChapterModel::update([
            'content' => $content,
            'status' => 1,
        ], ['id' => $bookChapter['id']]);
    }
    /**
     * 获取章节内容
     * @method   getContent
     * @DateTime 2017-05-12T10:10:51+0800
     * @param    [type]                   $chapterDom [description]
     * @param    [type]                   $selector   [description]
     * @return   [type]                               [description]
     */
    protected function getContent($url, $gather)
    {
        // url 处理
        $chapterUrl = $this->montageUrl($url);

        $chapterDom = $this->load($chapterUrl);
        $contentDom = $chapterDom->find($gather['content'], 0);
        if (empty($contentDom)) {
            return null;
        }
        $content = strip_tags($contentDom->innerHtml(), '<p><a><br>');
        // 内容替换
        $content = $this->replace($content, $gather['replace']);
        $content = str_ireplace(' ', '', $content);
        $content = str_ireplace('$nbsp;', '', $content);
        return "<p>{$content}</p>";
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
            $local = $this->getHost($this->rule['list_url'], true);
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
    protected function title($title, $replace)
    {
        if (!empty($replace)) {
            // 内容替换
            $title = $this->replace($title, $replace);
        }
        return trim($title);
    }
    /**
     * 内容替换
     * @method   replace
     * @DateTime 2017-05-12T12:28:47+0800
     * @param    [type]                   $value   [description]
     * @param    [type]                   $replace [description]
     * @return   [type]                            [description]
     */
    protected function replace($value, $replace)
    {
        if (empty($replace)) {
            return $value;
        }
        foreach ($replace as $key => $val) {
            $value = str_ireplace($val['search'], $val['replace'], $value);
        }
        return $value;
    }
    /**
     * 获取采集配置
     * @method   getGather
     * @DateTime 2017-05-11T16:36:29+0800
     * @return   [type]                   [description]
     */
    protected function getGather()
    {
        return GatherModel::get($this->rule['gather_id']);
    }
    /**
     * 获取文件 本地&远程
     * @author luffy<luffyzhao@vip.126.com>
     * @dateTime 2016-04-15T15:21:35+0800
     * @param    [type]                   $url [description]
     * @return   [type]                        [description]
     */
    protected function load($url)
    {
        $html = file_get_contents($url);
        return new ParserDom($html);
    }
}
