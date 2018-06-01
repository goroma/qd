<?php

namespace api\common\controllers;

use Yii;
use yii\rest\ActiveController;

class SendMessageController extends ActiveController
{
    public $modelClass = 'api\common\models\SmsLog';

    /**
     * 错误处理.
     */
    public function actionError()
    {
        return ['code' => 404, 'message' => '请求错误'];
    }

    /**
     * 发送验证码.
     */
    public function actionSendVerifyCode()
    {
        $request = Yii::$app->request;

        $monolog = Yii::$app->monolog;
        $logger = $monolog->getLogger('api');
        $logger->log('info', __CLASS__.'::'.__FUNCTION__.'():', $request->post());

        Yii::$app->ApiCommon->verifyParamIsEmpty(['mobile'], $request);

        $mobile = $request->post('mobile');

        if (($result = Yii::$app->PregMatch->phone($mobile)) != []) {
            throw new BadRequestHttpException($result['message'], $result['code']);
        }

        $model = $this->modelClass;

        // 验证此手机号是否需要发送手机验证码.
        if ($model::findValidCodeByMobile($mobile)) {
            return ['code' => 400, 'message' => '验证码已发送，请耐心等待！'];
        }

        if ($model::sendCodeMessage($mobile)) {
            return ['code' => 200, 'message' => '发送成功！'];
        } else {
            return ['code' => 400, 'message' => '发送失败！'];
        }
    }
}
