<?php
namespace app\api\model;

use think\Model;

class WxSign extends Model
{
    protected $auto = ['tokey_session'];

    protected $updateTime = 'modify_time';
    /**
     * 获取TokeySession
     * @method   getTokeySession
     * @DateTime 2017-05-26T11:43:21+0800
     * @param    [type]                   $openid     [description]
     * @param    [type]                   $sessionKey [description]
     * @return   [type]                               [description]
     */
    public static function getTokeySession($openid, $sessionKey)
    {
        $sign = self::get([
            'openid' => $openid,
        ]);
        if (!empty($sign) && $sign['session_key'] == $sessionKey) {
            return $sign['tokey_session'];
        } else if (empty($sign)) {
            $sign = new static;
        }

        $sign->session_key = $sessionKey;
        $sign->openid = $openid;
        $sign->tokey_session = $sessionKey;
        $sign->save();
        return $sign['tokey_session'];
    }

    /**
     * 设置tokeySession
     * @method   getTokeySessionAttr
     * @DateTime 2017-05-26T11:48:02+0800
     * @param    string                   $value [description]
     * @return   [type]                          [description]
     */
    protected function setTokeySessionAttr($value, $data)
    {
        return uniqid(microtime(true), true) . md5(uniqid(microtime(true), true));
    }
}
