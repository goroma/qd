<?php

namespace common\models\common;

use Yii;
use yii\base\Model;
use common\models\wechat\WeChatAccount;
use EasyWeChat\Foundation\Application;

class WeChat extends Model
{
    /**
     * 获取微信的配置.
     */
    public static function getWeChatOption(WeChatAccount $account)
    {
        $certPath = realpath(__DIR__.'/../../config/wechatpay/');
        $wechatOption = [
            'debug' => true,
            'app_id' => '',
            'secret' => '',
            'token' => '',
            'company_id' => 0,
            'wechat_account_id' => 0,
            // 'aes_key' => null,
            'oauth' => [
                'scopes' => ['snsapi_userinfo'],
                'callback' => '/site/we-chat-web-oauth',
            ],
            'log' => [
                'level' => 'debug',
                'file' => '/log/wechat/easywechat'.date('Ym').'_.log',
            ],
            'payment' => [
                'merchant_id' => '1338862501',
                'key' => 'f68f1ca6f799bec95ecb4face55b070b',
                'cert_path' => $certPath.'/apiclient_cert.pem', // XXX: 绝对路径！！！！
                'key_path' => $certPath.'/apiclient_key.pem',  // XXX: 绝对路径！！！！
                'notify_url' => 'http://api.blianb.com/v2/we-chat-pay-notifies', // 你也可以在下单时单独设置来想覆盖它
                // 'device_info'     => '013467007045764',
                // 'sub_app_id'      => '',
                // 'sub_merchant_id' => '',
                // ...
            ],
        ];

        $wechatOption['app_id'] = $account->app_id;
        $wechatOption['secret'] = $account->app_secret;
        $wechatOption['token'] = $account->token;
        $wechatOption['company_id'] = $account->company_id;
        $wechatOption['wechat_account_id'] = $account->id;

        return $wechatOption;
    }

    /**
     * 获取微信的应用.
     */
    public static function getWeChatApp(WeChatAccount $account)
    {
        return new Application(self::getWeChatOption($account));
    }

    /**
     * 使用websocket向前台推送微信用户的聊天信息.
     */
    public static function pushWeChatUserChat($openId, $message, $type)
    {
        $content = json_encode(['code' => 200, 'message' => $message, 'msgType' => $type]);
        $data = ['userId' => $openId, 'message' => $content];
        $dataProvider = Yii::$app->websocket->send(json_encode($data));
    }
}
