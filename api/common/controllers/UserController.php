<?php

namespace api\common\controllers;

use Yii;
use yii\rest\ActiveController;

class UserController extends ActiveController
{
    public $modelClass = 'api\common\models\User';

    /**
     * 错误处理.
     */
    public function actionError()
    {
        return ['code' => 404, 'message' => '请求错误'];
    }

    /**
     * 注册.
     */
    public function actionRegister()
    {
        $request = Yii::$app->request;
        if (($result = Yii::$app->ApiCommon->verifyParamIsEmpty(['username', 'password', 'role'], $request)) != []) {
            return $result;
        }
        $username = $request->post('username');
        $password = $request->post('password');
        $role = $request->post('role');

        if (($result = Yii::$app->PregMatch->phone($username)) != []) {
            throw new BadRequestHttpException($result['message'], $result['code']);
        }
        if (($result = Yii::$app->PregMatch->password($password)) != []) {
            throw new BadRequestHttpException($result['message'], $result['code']);
        }

        $model = $this->modelClass;
        if (!in_array($role, [$model::NURSERY, $model::PARENTS, $model::TEACHER])) {
            return [
                'message' => '创建用户的角色不正确!',
                'code' => 400,
            ];
        }

        $monolog = Yii::$app->monolog;
        $logger = $monolog->getLogger('api');
        $logger->log('info', __CLASS__.'::'.__FUNCTION__.'():', $request->post());

        if ($model::findByUsername($username)) {
            return [
                'message' => '手机号已注册,请更换手机号重试!',
                'code' => 400,
            ];
        }

        $user = $model::register($username, $password, $role);
        if ($user) {
            return [
                'code' => 200,
                'message' => '注册成功!',
                'data' => [
                    'access_token' => $user->auth_key,
                    'user_info' => $user::getIdentityId($user),
                ],
            ];
        } else {
            return [
                'message' => '注册失败,请稍后重试!',
                'code' => 400,
            ];
        }
    }

    /**
     * 登录.
     */
    public function actionLogin()
    {
        $request = Yii::$app->request;
        if (($result = Yii::$app->ApiCommon->verifyParamIsEmpty(['username', 'password'], $request)) != []) {
            return $result;
        }

        $username = $request->post('username');
        $password = $request->post('password');

        $monolog = Yii::$app->monolog;
        $logger = $monolog->getLogger('api');
        $logger->log('info', __CLASS__.'::'.__FUNCTION__.'():', $request->post());

        $model = $this->modelClass;

        if (($user = $model::findByUsername($username)) == null) {
            return [
                'message' => '登录失败',
                'code' => 400,
            ];
        }

        if ($user->validatePassword($password) && Yii::$app->user->login($user)) {
            $user->generateAuthKey();
            if (!$user->save()) {
                return [
                    'message' => '登录失败',
                    'code' => 400,
                ];
            }

            return [
                'code' => 200,
                'message' => '登录成功!',
                'data' => [
                    'access_token' => Yii::$app->user->identity->getAuthKey(),
                    'user_info' => $user::getIdentityId($user),
                ],
            ];
        } else {
            return [
                'message' => '登录失败',
                'code' => 400,
            ];
        }
    }

    public function actionResetToken()
    {
    }

    /**
     * 发送找回密码邮件.
     */
    public function actionSendPasswordResetTokenMail($email)
    {
        $monolog = Yii::$app->monolog;
        $logger = $monolog->getLogger('api');
        $logger->log('info', __CLASS__.'::'.__FUNCTION__.'():'.$email);

        $model = $this->modelClass;
        if (($user = $model::findByEmail($email)) == null) {
            return [
                'message' => '邮箱未注册',
                'code' => 400,
            ];
        }
        $user->generatePasswordResetToken();
        if (!$user->save()) {
            return [
                'message' => '邮件发送失败,请稍后再试',
                'code' => 400,
            ];
        }

        $subject = '找回密码';
        $template = 'passwordResetToken-html';

        $mail = Yii::$app->mailer->compose($template, ['user' => $user]);
        $mail->setTo($email)->setSubject($subject);

        if ($mail->send()) {
            return [
                'message' => '邮件发送成功',
                'code' => 200,
            ];
        } else {
            return [
                'message' => '邮件发送失败',
                'code' => 400,
            ];
        }
    }
}
