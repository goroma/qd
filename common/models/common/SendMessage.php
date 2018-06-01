<?php

namespace common\models\common;

use Yii;
use yii\base\Model;
use yii\httpclient\Client;

class SendMessage extends Model
{
    public $url = 'http://m.5c.com.cn/api/send/?';
    public $uid;
    public $pwd;
    public $apikey;
    public $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->uid = Yii::$app->params['sms']['uid'];
        $this->pwd = Yii::$app->params['sms']['pwd'];
        $this->apikey = Yii::$app->params['sms']['apikey'];
    }

    /**
     * @param $mobile string 手机号
     * @param $message string 短信内容
     * @param $time int unix时间戳，不写为立刻
     *
     * @return string success:msgid 提交成功。
     *                error:msgid  提交失败
     *                error:Missing username  用户名为空
     *                error:Missing password  密码为空
     *                error:Missing apikey  APIKEY为空
     *                error:Missing recipient  手机号码为空
     *                error:Missing message content  短信内容为空
     *                error:Account is blocked  帐号被禁用
     *                error:Unrecognized encoding  编码未能识别
     *                error:APIKEY or password error  APIKEY或密码错误
     *                error:Unauthorized IP address  未授权 IP 地址
     *                error:Account balance is insufficient  余额不足
     */
    public function sendMessage($mobile, $message, $time = 0)
    {
        $param = [];
        $param['username'] = $this->uid;
        $param['password'] = $this->pwd;
        $param['apikey'] = $this->apikey;
        $param['mobile'] = $mobile;
        $param['content'] = iconv('UTF-8', 'GB2312', $message);

        $response = $this->client->post($this->url, $param)->send();
        if ($response->isOk) {
            return $response->content;
        } else {
            return false;
        }
    }
}
