<?php

namespace common\models\common;

use Yii;
use yii\base\Model;
use yii\httpclient\Client;

class YsSDK extends Model
{
    public $url = 'https://open.ys7.com/api/lapp/';
    public $client;
    public $appKey;
    public $appSecret;

    public function __construct()
    {
        $this->client = new Client();
        $this->appKey = Yii::$app->params['camera']['appKey'];
        $this->appSecret = Yii::$app->params['camera']['appSecret'];
    }

    /**
     * 获取萤石access_token.
     */
    public function getAccessToken()
    {
        $tokenFile = '/tmp/ys_access_token';
        if (file_exists($tokenFile)) {
            $tokenJson = file_get_contents($tokenFile);
            $token = json_decode($tokenJson);
            if (floor($token->expireTime / 1000) - 86400 > time()) {
                return $token->accessToken;
            }
        }

        $url = $this->url.'token/get';
        $data = [
            'appKey' => $this->appKey,
            'appSecret' => $this->appSecret,
        ];

        $response = $this->client->post($url, $data)->send();
        if ($response->isOk && 200 == $response->data['code']) {
            file_put_contents($tokenFile, json_encode($response->data['data']));

            return $response->data['data']['accessToken'];
        }

        return $response->data;
    }

    /**
     * 添加设备.
     */
    public function addDevice($deviceSerial, $validateCode)
    {
        $url = $this->url.'device/add';
        $data = [
            'accessToken' => $this->getAccessToken(),
            'deviceSerial' => $deviceSerial,
            'validateCode' => $validateCode,
        ];
        $response = $this->client->post($url, $data)->send();

        return $response->data;
    }

    /**
     * 删除设备.
     */
    public function deleteDevice($deviceSerial)
    {
        $url = $this->url.'device/delete';
        $data = [
            'accessToken' => $this->getAccessToken(),
            'deviceSerial' => $deviceSerial,
        ];
        $response = $this->client->post($url, $data)->send();

        return $response->data;
    }

    /**
     * 设备截图.
     */
    public function deviceCapture($deviceSerial, $channelNo, $quality = 1)
    {
        $url = $this->url.'device/capture';
        $data = [
            'accessToken' => $this->getAccessToken(),
            'deviceSerial' => $deviceSerial,
            'channelNo' => $channelNo,
            'quality' => $quality,
        ];
        $response = $this->client->post($url, $data)->send();

        return $response->data;
    }

    /**
     * 修改设备名称.
     */
    public function modifyDeviceName($deviceSerial, $deviceName)
    {
        $url = $this->url.'device/name/update';
        $data = [
            'accessToken' => $this->getAccessToken(),
            'deviceSerial' => $deviceSerial,
            'deviceName' => $deviceName,
        ];
        $response = $this->client->post($url, $data)->send();

        return $response->data;
    }

    /**
     * 获取直播地址.
     */
    public function getVideoAddress($deviceSerial, $channelNo, $expireTime = 62208000)
    {
        $url = $this->url.'live/address/limited';
        $data = [
            'accessToken' => $this->getAccessToken(),
            'deviceSerial' => $deviceSerial,
            'channelNo' => $channelNo,
        ];
        $response = $this->client->post($url, $data)->send();

        return $response->data;
    }

    /**
     * 开通直播.
     */
    public function openVideo($source)
    {
        $url = $this->url.'live/video/open';
        $data = [
            'accessToken' => $this->getAccessToken(),
            'source' => $source,
        ];
        $response = $this->client->post($url, $data)->send();

        return $response->data;
    }
}
