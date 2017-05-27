<?php
namespace app\admin\command;

use luffyzhao\helper\Command;
use think\console\Input;
use think\console\Output;
use think\Db;
use think\Exception;
use think\exception\PDOException;
use think\Log;

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
        $this->lock();
        Db::startTrans();
        try {
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
                    $wordCount = $book['word_count'];
                    $bookChapterId = $book['last_chapter_id'];
                    // 不需要更新
                    if ($chapterJson['chapterTotalCnt'] <= $chapterTotal) {
                        $output->writeln($book['name'] . '没有要更新的章节!!');
                        continue;
                    }

                    try {
                        // 没有更新的章节
                        $data = $this->notUpdateChapter($chapterJson['vs'], $book['id']);
                        if (empty($data)) {
                            $output->writeln($book['name'] . '没有要更新的章节!');
                            continue;
                        }
                        $chunks = collection($data)->chunk(200);
                        foreach ($chunks as $key => $value) {
                            Db::name('book_chapter')->insertAll($value->toArray());

                            $wordCount += array_sum(array_column($value->toArray(), 'word_count'));
                            $chapterTotal += count($value);
                        }
                        $bookChapterId = $this->bookChaperId($book['id']);
                        $output->writeln($book['name'] . '更新完毕!');

                        $this->updateBook($book['id'], [
                            'last_chapter_id' => $bookChapterId,
                            'chapter_total' => $chapterTotal,
                            'word_count' => $wordCount,
                        ]);

                        Db::commit();
                    } catch (Exception $e) {
                        Log::record($e->getMessage(), 'error');
                        $output->writeln($e->getMessage());
                        Db::rollback();
                    }

                }
            }, 'a.id');
        } catch (PDOException $e) {
            Log::record($e->getMessage(), 'error');
            $output->writeln('运行失败！' . $e->getMessage());
        }

        $this->lock(false);
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
     * 获取章节分卷
     * @method   getSubsection
     * @DateTime 2017-05-13T10:05:50+0800
     * @param    string                   $value [description]
     * @return   [type]                          [description]
     */
    protected function getSubsection($bookId)
    {
        return Db::name('book_subsection')->where('book_id', $bookId)->column('id,sort,chapter_count,word_count', 'name');
    }
    /**
     * 更新章节分卷
     * @method   updateSubsection
     * @DateTime 2017-05-13T10:40:02+0800
     * @return   [type]                   [description]
     */
    protected function updateSubsection($id, $group)
    {
        return Db::name('book_subsection')->where('id', $id)->update([
            'chapter_count' => $group['wC'],
            'word_count' => $group['wC'],
        ]);
    }
    /**
     * 新增章节分卷
     * @method   insertSubsection
     * @DateTime 2017-05-13T10:42:21+0800
     * @param    string                   $value [description]
     * @return   [type]                          [description]
     */
    protected function insertSubsection($bookId, $group)
    {
        $date = date('Y-m-d H:i:s');
        return Db::name('book_subsection')->insertGetId([
            'book_id' => $bookId,
            'name' => $group['vN'],
            'sort' => $group['vS'],
            'chapter_count' => $group['cCnt'],
            'word_count' => $group['wC'],
            'create_time' => $date,
            'modify_time' => $date,
        ]);
    }
    /**
     * 没有更新的章节
     * @method   notUpdateChapter
     * @DateTime 2017-05-13T10:04:55+0800
     * @param    [type]                   $data   [description]
     * @param    [type]                   $bookId [description]
     * @return   [type]                           [description]
     */
    protected function notUpdateChapter($data, $bookId)
    {
        $array = [];
        $subsections = $this->getSubsection($bookId);

        foreach ($data as $group) {
            $chapter = [];
            if (isset($subsections[$group['vN']])) {
                if ($subsections[$group['vN']]['chapter_count'] < $group['cCnt']) {
                    $newChapter = array_slice($group['cs'], $subsections[$group['vN']]['chapter_count']);
                    $chapter = $this->data($newChapter, $bookId, $subsections[$group['vN']]['id']);
                    $this->updateSubsection($subsections[$group['vN']]['id'], $group);
                }
            } else {
                $subsectionId = $this->insertSubsection($bookId, $group);
                $chapter = $this->data($group['cs'], $bookId, $subsectionId);
            }
            $array = array_merge($array, $chapter);
        }
        return $array;
    }

    /**
     * 章节数据
     * @method   chapter
     * @DateTime 2017-05-13T10:26:05+0800
     * @param    [type]                   $newChapter   [description]
     * @param    [type]                   $subsectionId [description]
     * @return   [type]                                 [description]
     */
    protected function data($newChapter, $bookId, $subsectionId)
    {
        $array = [];
        if (empty($newChapter)) {
            return $array;
        }

        foreach ($newChapter as $key => $value) {
            $array[] = [
                'book_id' => $bookId,
                'name' => $value['cN'],
                'word_count' => $value['cnt'],
                'subsection_id' => $subsectionId,
                'create_time' => $value['uT'],
            ];
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
        return Db::connect([], 'chapter_chunk')->name('book')->alias('a')
            ->field(['id', 'name', 'isbn', 'end_status', 'chapter_total', 'last_chapter_id', 'word_count'], false, 'book')
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
