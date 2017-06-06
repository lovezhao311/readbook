<?php
namespace app\admin\command;

use app\admin\library\ParserDom;
use luffyzhao\helper\Command;
use think\console\Input;
use think\console\Output;
use think\Db;
use think\Exception;

class AddBook extends Command
{
    protected $gatherList = null;

    protected $cateList = [
        '玄幻' => 2,
        '仙侠' => 1,
        '奇幻' => 3,
        '职场' => 5,
        '二次元' => 6,
        '灵异' => 7,
        '科幻' => 8,
        '体育' => 9,
        '游戏' => 10,
        '军事' => 11,
        '历史' => 12,
        '都市' => 13,
        '武侠' => 14,
        '短篇' => 15,
        '古代言情' => 16,
        '仙剑情缘' => 17,
        '现代言情' => 18,
        '浪漫青春' => 19,
        '玄幻言情' => 20,
        '悬疑灵异' => 21,
        '科幻空间' => 22,
        '游戏竞技' => 23,
    ];
    /**
     * [configure description]
     * @method   configure
     * @DateTime 2017-05-11T03:56:07+0800
     * @return   [type]                   [description]
     */
    protected function configure()
    {
        $this->setName('book')->setDescription('获取书籍。');
    }

    /**
     *
     * @method   execute
     * @DateTime 2017-05-11T03:56:10+0800
     * @param    Input                    $input  [description]
     * @param    Output                   $output [description]
     * @return   [type]                           [description]
     */
    protected function execute(Input $input, Output $output)
    {
        $this->lock();

        // 书籍分页
        $pageNum = 1;
        $maxPageNum = 1;
        while (true) {
            if ($pageNum > $maxPageNum) {
                break;
            }
            //获取书籍列表
            $lists = $this->book($pageNum);
            if ($lists == false) {
                $output->writeln('第'+$pageNum+'数据错误~');
                break;
            }
            // 最大页面
            $maxPageNum = $lists['pageMax'];
            // 书籍内容
            $records = $lists['records'];
            $data = [];
            foreach ($records as $key => $value) {
                $value = $this->data($value);
                if ($value != false) {
                    $data[] = $value;
                }
            }
            if (!empty($data)) {
                Db::name('book')->insertAll($data);
            }
            $pageNum++;
        }

        $this->lock(false);
    }

    /**
     * data
     * @method   data
     * @DateTime 2017-05-31T15:34:06+0800
     * @param    [type]                   $data [description]
     * @return   [type]                         [description]
     */
    protected function data($data)
    {
        $count = Db::name('book')->where('isbn', $data['bid'])->count();
        if ($count == 1) {
            return false;
        }
        try {
            $gather = $this->getGather($data['bName']);
        } catch (Exception $e) {
            return false;
        }

        $date = date('Y-m-d H:i:s');
        return [
            'source_id' => 3,
            'name' => $data['bName'],
            'alias' => $data['bName'],
            'image' => "http://qidian.qpic.cn/qdbimg/{$data['cid']}/{$data['bid']}/150",
            'isbn' => $data['bid'],
            'remark' => $data['desc'],
            'author_name' => $data['bAuth'],
            'gather' => $gather,
            'tags' => $this->cateList[$data['cat']],
            'types' => '[]',
            'end_status' => $data['state'] == '连载' ? 1 : 2,
            'create_time' => $date,
            'modify_time' => $date,
        ];
    }
    /**
     * 书籍采集页面
     * @method   getGather
     * @DateTime 2017-05-31T16:21:23+0800
     * @param    [type]                   $name [description]
     * @return   [type]                         [description]
     */
    protected function getGather($name)
    {
        if ($this->gatherList == null) {
            $this->gatherList = $this->getGatherList();
        }
        $list = [];
        foreach ($this->gatherList as $key => $value) {
            $url = str_ireplace('{$bookname}', $name, $value['search']);
            $listDom = $this->load($url);
            $bookList = $listDom->find($value['search_regular']);
            if (empty($bookList)) {
                continue;
            }
            foreach ($bookList as $val) {
                if (trim($val->getPlainText()) == $name) {
                    $list[] = [
                        'gather_id' => $value['id'],
                        'list_url' => $val->href,
                    ];
                    continue;
                }
            }
        }
        if (empty($list)) {
            throw new Exception('还没有采集源.');
        }
        return json_encode($list);
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
    /**
     * 获取采集列表
     * @method   getGatherList
     * @DateTime 2017-05-31T16:19:59+0800
     * @return   [type]                   [description]
     */
    protected function getGatherList()
    {
        return Db::name('gather')->field('id,search,search_regular')->select();
    }
    /**
     * 获取书籍
     * @method   book
     * @DateTime 2017-05-31T15:02:03+0800
     * @param    [type]                   $pageNum [description]
     * @param    [type]                   $catId   [description]
     * @return   [type]                            [description]
     */
    protected function book($pageNum = 1)
    {
        $url = "http://m.qidian.com/majax/category/list?pageNum={$pageNum}&catId=23";
        //初始化
        $ch = curl_init();
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        //执行并获取HTML文档内容
        $output = curl_exec($ch);
        //释放curl句柄
        curl_close($ch);
        $result = json_decode($output, true);
        if (isset($result['code']) && $result['code'] == 0) {
            return $result['data'];
        }
        return false;
    }
}
