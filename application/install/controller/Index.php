<?php
/**
 * Created by PhpStorm.
 * User: luffyzhao
 * Date: 2017/2/16
 * Time: 9:25
 */

namespace app\install\controller;

use think\Controller;
use think\Db;
use think\Validate;

class Index extends Controller
{

    protected function _initialize()
    {
        if (file_exists(RUNTIME_PATH . '.lock')) {
            $this->redirect('admin/index/index');
        }
    }

    /**
     * 系统检查
     * @return mixed
     */
    public function index()
    {
        $checks = [
            'pdo' => extension_loaded('pdo'),
            'curl' => extension_loaded('curl'),
            'mbstring' => extension_loaded('mbstring'),
            'gd' => extension_loaded('gd'),
            'phpversion' => version_compare("5.4", PHP_VERSION, "<"),
            'cache_is_w' => $this->_pathWritable(CACHE_PATH),
            'runtime_is_w' => $this->_pathWritable(RUNTIME_PATH),
            'temp_is_w' => $this->_pathWritable(TEMP_PATH),
            'log_is_w' => $this->_pathWritable(LOG_PATH),
        ];

        $this->assign('checks', $checks);
        return $this->fetch();
    }

    /**
     * 系统配置
     */
    public function config()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $validate = new Validate([
                'hostname' => 'require|ip',
                'username' => 'require',
                'hostport' => 'require|integer',
                'database' => 'require|alphaDash',
            ]);
            if (!$validate->batch(true)->check($data)) {
                $this->assign('errorInfo', $validate->getError());
                return $this->fetch();
            } else {
                session('luffy_install', $data);
                $this->redirect('index/setting');
            }
        }

        return $this->fetch();
    }

    /**
     * 安装CMS
     * @return mixed|void
     */
    public function setting($go = false)
    {
        $sessionData = session('luffy_install');
        if (!$sessionData) {
            return $this->redirect('index/config');
        }

        if ($go) {
            $dns = "mysql://{$sessionData['username']}:{$sessionData['password']}@{$sessionData['hostname']}:{$sessionData['hostport']}/#utf8";
            try {
                // 连接
                $db = Db::connect($dns);
                $this->_showjsmessage('数据库连接成功！');
                // 创建数据库
                $db->execute("DROP DATABASE IF EXISTS `{$sessionData['database']}`");
                $db->execute("CREATE DATABASE `{$sessionData['database']}` CHARACTER SET utf8");
                $this->_showjsmessage('数据库' . $sessionData['database'] . '创建成功！');

                $dns = "mysql://{$sessionData['username']}:{$sessionData['password']}@{$sessionData['hostname']}:{$sessionData['hostport']}/{$sessionData['database']}#utf8";
                $db = Db::connect($dns);
                // 执行sql
                $filename = APP_PATH . "install/database/book.sql";
                $sqlArray = $this->_import($filename);
                foreach ($sqlArray as $sql) {
                    $db->execute($sql);
                    $this->_showjsmessage("执行sql语句：<br />{$sql}");
                }
                $this->_showjsmessage('数据库加载完成！');

                $filename = APP_PATH . "database.php";
                //
                $dataConfig = include $filename;
                $dataConfig = array_merge($dataConfig, $sessionData);
                $dataString = "<?php\r\n return " . var_export($dataConfig, true) . ';';
                file_put_contents($filename, $dataString);
                $this->_showjsmessage('cms配置完成！');
                file_put_contents(RUNTIME_PATH . '.lock', THINK_START_TIME);
                session(null);
                $this->_showjsmessage('跳转中...');
                $this->_jump('admin/index/index');
            } catch (\Exception $e) {
                $this->_showjsmessage($e->getMessage(), 'danger');
            }
            return;
        }

        return $this->fetch();
    }

    /**
     * 跳转
     * @param $url
     */
    protected function _jump($url)
    {
        echo '<script type="text/javascript">parent.location.href=\'' . url($url) . '\'</script>';
        ob_flush();
        flush();
    }
    /**
     * 页面输出
     * @param $message
     */
    protected function _showjsmessage($message, $type = 'success')
    {
        $message = str_ireplace("\n", '', $message);
        $message = str_ireplace("\r", '', $message);
        echo '<script type="text/javascript">parent.show(\'' . addslashes($message) . '\',\'' . $type . '\');</script>';
        ob_flush();
        flush();
    }

    /**
     * 将sql导入到数据库（普通导入）
     *
     * @param string $sqlfile
     * @return boolean
     */
    private function _import($sqlfile)
    {
        // sql文件包含的sql语句数组
        $sqls = array();
        $f = fopen($sqlfile, "rb");
        // 创建表缓冲变量
        $create = '';
        while (!feof($f)) {
            // 读取每一行sql
            $line = fgets($f);
            // 如果包含'-- '等注释，或为空白行，则跳过
            if (trim($line) == '' || preg_match('/--.*/', $line, $match)) {
                continue;
            }
            // 如果结尾包含';'(即为一个完整的sql语句，这里是插入语句)，并且不包含'ENGINE='(即创建表的最后一句)，
            if (!preg_match('/;/', $line, $match) || preg_match('/ENGINE=/', $line, $match)) {
                // 将本次sql语句与创建表sql连接存起来
                $create .= $line;
                // 如果包含了创建表的最后一句
                if (preg_match('/ENGINE=/', $create, $match)) {
                    // 则将其合并到sql数组
                    $sqls[] = $create;
                    // 清空当前，准备下一个表的创建
                    $create = '';
                }
                // 跳过本次
                continue;
            }
            $sqls[] = $line;
        }
        fclose($f);

        return $sqls;
    }

    /**
     * @param $path
     */
    protected function _pathWritable($path)
    {
        if (!file_exists($path)) {
            return mkdir($path, 0755, true);
        }
        return is_writable($path);
    }
}
