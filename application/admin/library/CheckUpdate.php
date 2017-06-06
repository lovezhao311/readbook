<?php
namespace app\admin\library;

use think\Db;
use think\Exception;

/**
 *
 */
class CheckUpdate
{
    protected $type = 'cli';
    /**
     *
     * @method   __construct
     * @DateTime 2017-06-05T12:02:45+0800
     * @param    [type]                   $id [description]
     */
    public function __construct($type = 'cli')
    {
        $this->type = $type;
        $this->lock();
    }
    /**
     * 检查更新
     * @method   checkUpdate
     * @DateTime 2017-06-05T12:06:23+0800
     * @param    string                   $value [description]
     * @return   [type]                          [description]
     */
    public function check($id)
    {
        $book = $this->bookQuery($id);
        if (empty($book)) {
            throw new Exception('没有更新的章节');
        }
        $chapters = $this->chapter($book);
        if ($chapters === false) {
            throw new Exception('没有更新的章节');
        }
        // 不需要更新
        if ($chapters['chapterTotalCnt'] <= $book['chapter_total']) {
            throw new Exception('没有更新的章节');
        }

        $chapterTotal = $book['chapter_total'];
        $wordCount = $book['word_count'];
        $bookChapterId = $book['last_chapter_id'];

        try {
            // 没有更新的章节
            $data = $this->notUpdateChapter($chapters['vs'], $book['id']);
            if (empty($data)) {
                throw new Exception('没有更新的章节');
            }
            $chunks = collection($data)->chunk(200);
            foreach ($chunks as $key => $value) {
                Db::name('book_chapter')->insertAll($value->toArray());
                $wordCount += array_sum(array_column($value->toArray(), 'word_count'));
                $chapterTotal += count($value);
            }
            $bookChapterId = $this->bookChaperId($book['id']);
            $this->updateBook($book['id'], [
                'last_chapter_id' => $bookChapterId,
                'chapter_total' => $chapterTotal,
                'word_count' => $wordCount,
            ]);
            Db::commit();
        } catch (Exception $e) {
            Log::record($e->getMessage(), 'error');
            Db::rollback();
        }
        return true;

    }

    /**
     * 要更新的书籍
     * @method   bookQuery
     * @DateTime 2017-05-11T04:15:22+0800
     * @return   [type]                   [description]
     */
    protected function bookQuery($id)
    {
        $query = Db::connect([], 'chapter_chunk')->name('book')->alias('a')
            ->field(['id', 'name', 'isbn', 'end_status', 'chapter_total', 'last_chapter_id', 'word_count'], false, 'book')
            ->field(['id', 'name', 'url'], false, 'source', 'so', 'source_')
            ->join('source so', 'so.id=a.source_id')
            ->where('a.id', $id);

        if ($this->type != 'cli') {
            $query->where('a.end_status', 1);
        }

        return $query->find();
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
     * 来源地址
     * @method   sourceUrl
     * @DateTime 2017-05-11T13:30:21+0800
     * @return   [type]                   [description]
     */
    protected function chapter($book)
    {
        $url = $this->source($book['source_id']);

        $data['isbn'] = $book['isbn'];
        $data['_csrfToken'] = $this->csrfToken();
        foreach ($data as $key => $value) {
            $url = str_ireplace('{$' . $key . '}', $value, $url);
        }

        return $this->curlGet($url);
    }

    /**
     * 获取所有章节
     * @method   chapter
     * @DateTime 2017-05-11T13:16:35+0800
     * @param    [type]                   $book [description]
     * @return   [type]                         [description]
     */
    protected function curlGet($url)
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
     * 要更新的书籍
     * @method   bookQuery
     * @DateTime 2017-05-11T04:15:22+0800
     * @return   [type]                   [description]
     */
    protected function source($id)
    {
        return Db::name('source')->where('id', $id)->value('url');
    }

    /**
     * [__destruct description]
     * @method   __destruct
     * @DateTime 2017-06-05T14:23:13+0800
     */
    public function __destruct()
    {
        $this->lock(false);
    }
    /**
     * 文件锁
     * @method   lock
     * @DateTime 2017-04-26T12:00:05+0800
     * @param    bool                     $op [description]
     * @return   [type]                       [description]
     */
    protected function lock(bool $op = true)
    {
        $lockFile = RUNTIME_PATH . md5(get_class()) . '-' . $this->type . '.lock';
        if ($op === false) {
            if (file_exists($lockFile)) {
                @unlink($lockFile);
            }
        } else {
            if (file_exists($lockFile)) {
                throw new Exception('没有更新的章节');
            }
            // 创建
            touch($lockFile);
            if (preg_match('/linux/i', PHP_OS) || preg_match('/Unix/i', PHP_OS)) {
                chmod($lockFile, 0777);
            }
        }

    }
}
