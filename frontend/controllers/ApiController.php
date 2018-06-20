<?php
namespace frontend\controllers;

use Yii;
use yii\web\Response;
use yii\rest\Controller;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\auth\HttpBearerAuth;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

use common\models\InfHid;

use common\models\LoginForm;

use frontend\models\ContactForm;
use frontend\models\SignupForm;
use frontend\models\order\Order;

// payment SDK
use Payment\Config;
use Payment\Client\Charge;
use Payment\ChargeContext;
use Payment\Common\PayException;
use common\models\common\Payment;

/**
 * Api controller
 */
class ApiController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'only' => ['dashboard'],
        ];
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['dashboard'],
            'rules' => [
                [
                    'actions' => ['dashboard'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];
        return $behaviors;
    }

    public function actionLogin()
    {
        $model = new LoginForm();
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->login()) {
            return ['access_token' => Yii::$app->user->identity->getAuthKey()];
        } else {
            $model->validate();
            return $model;
        }
    }

    public function actionDashboard()
    {
        $response = [
            'username' => Yii::$app->user->identity->username,
            'access_token' => Yii::$app->user->identity->getAuthKey(),
        ];
        return $response;
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                $response = [
                    'flash' => [
                        'class' => 'success',
                        'message' => 'Thank you for contacting us. We will respond to you as soon as possible.',
                    ]
                ];
            } else {
                $response = [
                    'flash' => [
                        'class' => 'error',
                        'message' => 'There was an error sending email.',
                    ]
                ];
            }
            return $response;
        } else {
            $model->validate();
            return $model;
        }
    }

    /**
     * 注册
     */
    public function actionSignUp()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $user = $model->signup()) {
            return ['access_token' => $user->auth_key];
        } else {
            $model->validate();
            return $model;
        }
    }

    public function actionSearch()
    {
        try {
            $post = Yii::$app->getRequest()->getBodyParams();
            if (!in_array($post['type']['type'], [1, 2])) {
                $error = '请选择硬件ID或设备名称';
                throw new BadRequestHttpException($error, 400);
            }
            if (!isset($post['content']) || !$post['content']) {
                $error = '请输入需要搜索的内容';
                throw new BadRequestHttpException($error, 400);
            }

            $inf_hid = new InfHid();
            if (1 == $post['type']['type']) {
                $reg = '/^[a-zA-Z\\\0-9\*\_\{\}\&]+$/';
                $error = '提示请输入正确的硬件ID格式';
                if (!preg_match($reg, preg_quote($post['content']))) {
                    throw new BadRequestHttpException($error, 400);
                }

                $result = $inf_hid->getHidCount($post['content']);

                return ['data' => $result, 'message' => 'success'];
            } else {
                $result = $inf_hid->HidNameCount($post['content']);

                return ['data' => $result, 'message' => 'success'];
            }
        } catch (\Exception $e) {
            throw new NotFoundHttpException($e->getMessage(), 404);
        }
    }

    public function actionSearchContent()
    {
        try {
            $post = Yii::$app->getRequest()->getBodyParams();
            if (!in_array($post['type']['type'], [1, 2])) {
                $error = '请选择硬件ID或设备名称';
                throw new BadRequestHttpException($error, 400);
            }
            if (!isset($post['content']) || !$post['content']) {
                $error = '请输入需要搜索的内容';
                throw new BadRequestHttpException($error, 400);
            }

            $inf_hid = new InfHid();
            if (1 == $post['type']['type']) {
                $reg = '/^[a-zA-Z\\\0-9\*\_\{\}\&]+$/';
                $error = '提示请输入正确的硬件ID格式';
                if (!preg_match($reg, preg_quote($post['content']))) {
                    throw new BadRequestHttpException($error, 400);
                }

                $result = $inf_hid->HidSearch($post['content']);

                return ['data' => $result, 'message' => 'success'];
            } else {
                $result = $inf_hid->HidNameCount($post['content']);

                return ['data' => $result, 'message' => 'success'];
            }
        } catch (\Exception $e) {
            throw new NotFoundHttpException($e->getMessage(), 404);
        }
    }
}
