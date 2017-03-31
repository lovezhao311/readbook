<?php
namespace app\admin\library\traits;

use think\Db;

trait Validate
{

    /**
     * 验证是否存在！
     * @author luffy<luffyzhao@vip.126.com>
     * @dateTime 2016-04-19T09:48:57+0800
     * @param    [type]                   $roleId [description]
     * @return   [type]                           [description]
     */
    public function exist($value, $rule, $data)
    {
        if (is_string($rule)) {
            $rule = explode(',', $rule);
        }
        $db = Db::name($rule[0]);
        $field = isset($rule[1]) ? $rule[1] : 'id';
        $map = [$field => $value];

        if ($db->where($map)->field($field)->find()) {
            return true;
        }
        return false;
    }

    /**
     * 验证某个字段的值等于 x 时候必须
     * @param  [type] $value [description]
     * @param  [type] $data  [description]
     * @return [type]        [description]
     */
    public function requireWithForVal($value, $rule, $data)
    {
        list($field, $val) = explode(',', $rule, 2);

        if (isset($data[$field]) && $data[$field] == $val && trim($value) == '') {
            return false;
        }
        return true;
    }

    /**
     * 后缀
     * @param  [type] $value [description]
     * @param  [type] $rule  [description]
     * @return [type]        [description]
     */
    public function postfix($value, $rule)
    {
        $rules = explode(',', $rule);
        $postfix = strtolower(pathinfo($value, PATHINFO_EXTENSION));

        if (in_array($postfix, $rules)) {
            return true;
        }
        return false;
    }

    /**
     * 名称的验证
     * @method   name
     * @DateTime 2016-11-04T15:27:49+0800
     * @param    [type]                   $value [description]
     * @param    [type]                   $rule  [description]
     * @return   [type]                          [description]
     */
    public function title($value, $rule)
    {
        if (preg_match('/^[A-Za-z0-9_\x{4e00}-\x{9fa5}]{2,16}$/u', $value)) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * 密码验证
     * @method   password
     * @DateTime 2017-03-31T12:07:23+0800
     * @return   [type]                   [description]
     */
    public function password($value, $rule)
    {
        return preg_match('/^(.+){6,12}$/', $value);
    }

    /**
     * 用户名的验证
     * @method   name
     * @DateTime 2016-11-04T15:27:49+0800
     * @param    [type]                   $value [description]
     * @param    [type]                   $rule  [description]
     * @return   [type]                          [description]
     */
    public function username($value, $rule)
    {
        if (preg_match('/^[\x{4e00}-\x{9fa5}]{2,5}$/u', $value)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 地址的验证
     * @method   name
     * @DateTime 2016-11-04T15:27:49+0800
     * @param    [type]                   $value [description]
     * @param    [type]                   $rule  [description]
     * @return   [type]                          [description]
     */
    public function address($value, $rule)
    {
        if (preg_match('/^[A-Za-z0-9_\x{00}-\x{ff}]{2,25}$/', $value)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 手机号码
     * @method   money
     * @DateTime 2016-11-04T16:22:33+0800
     * @param    string                   $value [description]
     * @return   [type]                          [description]
     */
    public function phone($value, $rule)
    {
        if (preg_match('/^1(3|4|5|7|8)\d{9}$/', $value)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 电话号码
     * @method   money
     * @DateTime 2016-11-04T16:22:33+0800
     * @param    string                   $value [description]
     * @return   [type]                          [description]
     */
    public function tel($value, $rule)
    {
        if (preg_match('/^(\(\d{3,4}\)|\d{3,4}-|\s)?\d{7,14}$/', $value)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 邮编
     * @method   money
     * @DateTime 2016-11-04T16:22:33+0800
     * @param    string                   $value [description]
     * @return   [type]                          [description]
     */
    public function postiveInt($value, $rule)
    {
        if (preg_match('/^[1-9]*[1-9][0-9]*$/', $value)) {
            return true;
        } else {
            return false;
        }
    }
}
