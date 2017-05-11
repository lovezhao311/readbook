<?php
namespace app\admin\command;

use luffyzhao\helper\Command;
use think\console\Input;
use think\console\Output;
use think\Db;

class UpdateChapter extends Command
{
    /**
     * [configure description]
     * @method   configure
     * @DateTime 2017-05-11T03:56:07+0800
     * @return   [type]                   [description]
     */
    protected function configure()
    {
        $this->setName('chapter')->setDescription('获取书籍最新更新。');
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
        // $this->lock();
        $this->bookQuery()->chunk(20, function ($books) use ($output) {
            foreach ($books as $book) {
                if (empty($book['source_url'])) {
                    $output->writeln($book['name'] . '来源地址错误！');
                    continue;
                }
                $url = $this->sourceUrl($book);
                $chapterJson = $this->chapter($url);
                if ($chapterJson === false) {
                    $output->writeln($book['name'] . '获取章节列表失败！');
                    continue;
                }

                $chapterTotal = $book['chapter_total'];
                $wordCount = 0;
                $bookChapterId = 0;
                // 不需要更新
                if ($chapterJson['chapterTotalCnt'] <= $chapterTotal) {
                    continue;
                }
                //
                $chapters = $this->notUpdateChapter($chapterJson['vs'], $chapterTotal);
                if (empty($chapters)) {
                    continue;
                }
                $chapterData = [];
                foreach ($chapters as $chapter) {
                    $chapterData[] = [
                        'book_id' => $book['id'],
                        'name' => $chapter['cN'],
                        'word_count' => $chapter['cnt'],
                        'group' => $chapter['group'],
                        'create_time' => $chapter['uT'],
                        'modify_time' => $chapter['uT'],
                    ];
                    $wordCount += $chapter['cnt'];
                }
                $chaptersChunk = collection($chapterData)->chunk(1000);

                $bookData = ['chapter_total' => $chapterTotal, 'word_count' => $wordCount, 'last_chapter_id' => $bookChapterId];
                foreach ($chaptersChunk as $chunk) {
                    Db::startTrans();
                    try {
                        Db::name('book_chapter')->insertAll($chunk->toArray());
                        Db::commit();
                    } catch (Exception $e) {
                        Db::rollback();
                        $output->writeln($book['name'] . '章节更新失败!');
                        $this->updateBook($book['id'], $bookData);
                        continue;
                    }
                    $bookData['last_chapter_id'] = $this->bookChaperId($book['id']);
                    $bookData['chapter_total'] += count($chunk);
                }
                $this->updateBook($book['id'], $bookData);
            }
        }, 'a.id');

        // $this->lock(false);
    }

    /**
     * 获取最后更新的章节Id
     * @method   bookChaperId
     * @DateTime 2017-05-11T15:21:02+0800
     * @param    [type]                   $id [description]
     * @return   [type]                       [description]
     */
    protected function bookChaperId($id)
    {
        return Db::name('book_chapter')->where('book_id', $id)->order('id DESC')->value('id');
    }
    /**
     * 更新书籍
     * @method   updateBook
     * @DateTime 2017-05-11T15:23:07+0800
     * @param    [type]                   $id   [description]
     * @param    [type]                   $data [description]
     * @return   [type]                         [description]
     */
    protected function updateBook($id, $data)
    {
        Db::name('book')->where('id', $id)->update($data);
    }
    /**
     * 没有更新的章节
     * @method   notUpdateChapter
     * @DateTime 2017-05-11T14:13:50+0800
     * @param    [type]                   $data [description]
     * @return   [type]                         [description]
     */
    protected function notUpdateChapter($data, $chapterTotal)
    {
        $array = [];
        $i = 0;
        foreach ($data as $group) {
            foreach ($group['cs'] as $value) {
                // 未更新章节
                if ($i >= $chapterTotal) {
                    $array[$i] = $value;
                    $array[$i]['group'] = $group['vN'];
                }
                $i++;
            }
        }
        return $array;
    }
    /**
     * 获取所有章节
     * @method   chapter
     * @DateTime 2017-05-11T13:16:35+0800
     * @param    [type]                   $book [description]
     * @return   [type]                         [description]
     */
    protected function chapter($url)
    {
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

    /**
     * 来源地址
     * @method   sourceUrl
     * @DateTime 2017-05-11T13:30:21+0800
     * @return   [type]                   [description]
     */
    protected function sourceUrl($book)
    {
        $source = $book['source_url'];

        $data['isbn'] = $book['isbn'];
        $data['_csrfToken'] = $this->csrfToken();
        foreach ($data as $key => $value) {
            $source = str_ireplace('{$' . $key . '}', $value, $source);
        }

        return $source;
    }
    /**
     * 要更新的书籍
     * @method   bookQuery
     * @DateTime 2017-05-11T04:15:22+0800
     * @return   [type]                   [description]
     */
    protected function bookQuery()
    {
        return Db::name('book')->alias('a')
            ->field(['id', 'name', 'isbn', 'end_status', 'chapter_total'], false, 'book')
            ->field(['name', 'url'], false, 'source', 'so', 'source_')
            ->join('source so', 'so.id=a.source_id')
            ->where('end_status', 1);
    }
    /**
     * 生成 csrfToken
     * @method   csrfToken
     * @DateTime 2017-05-11T04:29:40+0800
     * @return   [type]                   [description]
     */
    protected function csrfToken()
    {
        $str = '2345678abcdefhijkmnpqrstuvwxyzABCDEFGHJKLMNPQRTUVWXY';
        $csrf = '';
        for ($i = 0; $i < 20; $i++) {
            $csrf .= $str[mt_rand(0, mb_strlen($str, 'utf-8') - 1)];
        }
        return $csrf;
    }
}
