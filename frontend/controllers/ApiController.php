<?php
namespace frontend\controllers;

use Yii;
use yii\web\Response;
use yii\rest\Controller;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\auth\HttpBearerAuth;

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

    /**
     * 在微信浏览器访问时,获取微信网页授权获取到的微信用户信息.
     */
    public function actionGetWeChatWebUser()
    {
        $session = Yii::$app->session;
        $session->open();

        if ($wechatUser = $session->get('wechat_user')) {
            return ['wechatUser' => $wechatUser];
        } else {
            return ['wechatUser' => ['id'=>'asdfa', 'name' => 'bobo']];
        }
    }

    public function actionPayment()
    {
        $request = Yii::$app->request;
        $post = $request->post();
        $channel = $post['pay_type'];
        $config = Payment::getPaymentConfig($post['type']);

        // 订单数组
        $order_no = date('Ymdhis').substr(microtime(), 2, 1).rand(0,9);
        $orderData = [
            "order_no"	=> $order_no,
            "amount"	=> '0.01',// 单位为元 ,最小为0.01
            "client_ip"	=> '127.0.0.1',
            "subject"	=> '测试支付',
            "body"	=> '支付接口测试',
            'timeout_express' => time() + 600,
            //"show_url"  => 'http://mall.tiyushe.com/goods/23.html',
        ];

        // 实例化环境类
        //$charge = new ChargeContext();

        //try {
            //$orderData['openid'] = 'ofTN_wajIjD_cbPl8G14YSTOSNxE';

            //$charge->initCharge($type, $config);

            //$res = $charge->charge($orderData);

            //// 创建订单
            //Order::createOrder($orderData);
        //} catch (PayException $e) {
            //echo $e->errorMessage();exit;
        //}

        $orderData['openid'] = 'ofTN_wajIjD_cbPl8G14YSTOSNxE';
        try {
            $ret = Charge::run($channel, $config, $orderData);
        } catch (PayException $e) {
            echo $e->errorMessage();
            exit;
        }

        if (is_array($ret)) {
            return $ret;
        } else {
            if ('wx_pub' == $channel) {
                return json_decode($ret);
            } else {
                return $ret;
            }
        }

        //if ($type === Config::ALI_CHANNEL_APP) {
            //var_dump($res);
        //} elseif ($type === Config::WX_CHANNEL_QR) {

            //$url = urlencode($res);
            //echo "<img alt='扫码支付' src='http://paysdk.weixin.qq.com/example/qrcode.php?data={$url}' style='width:150px;height:150px;'/>";
        //} elseif ($type === Config::WX_CHANNEL_PUB) {
            //return json_decode($res);
        //} elseif (stripos($type, 'wx') !== false) {
            //var_dump($res);
        //} else {
            //return $res;
            //// 跳转支付宝
            ////header("Location:{$res}");
        //}
    }
}
