<?php
namespace app\api\controller;

use app\api\model\WxRelation;
use app\api\model\WxSign;
use luffyzhao\helper\Controller;
use luffyzhao\wxhelper\exception\RequestException;
use luffyzhao\wxhelper\request\SessionKey;
use think\Config;
use think\Exception;

/**
 *
 */
class Client extends Controller
{
    /**
     * 验证
     * @method   sign
     * @DateTime 2017-05-26T12:15:05+0800
     * @return   [type]                   [description]
     */
    public function sign()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            $appid = Config::get('app_for_wechat.appid');
            $appsecret = Config::get('app_for_wechat.appsecret');
            // 换取seesionkey和openid
            try {
                $this->validate($data, 'sign');
                $sessionKey = new SessionKey($appid, $appsecret);
                $sessionKey->setJsCode($data['code']);
                $result = $sessionKey->run();
                $tokeySession = WxSign::getTokeySession($result['openid'], $result['session_key']);

                $clientId = WxRelation::where('openid', $result['openid'])->value('client_id');

            } catch (Exception $e) {
                $this->error($e->getMessage());
            } catch (RequestException $e) {
                $this->error($e->getMessage());
            }

            $this->result([
                'tokey' => $tokeySession,
                'clientId' => (int) $clientId,
            ], 1);
        }
    }
}
