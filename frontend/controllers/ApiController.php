<?php
namespace frontend\controllers;

use Yii;
use yii\web\Response;
use yii\rest\Controller;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\auth\HttpBearerAuth;
use yii\web\BadRequestHttpException;

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

    public function actionSearch()
    {
        $post = Yii::$app->getRequest()->getBodyParams();
        //print_r($post);
        //die;
        if (!in_array($post['type']['type'], [1, 2])) {
            $error = '请选择硬件ID或设备名称';
            throw new BadRequestHttpException($error, 400);
        }
        if (!isset($post['content']) || !$post['content']) {
            $error = '请输入需要搜索的内容';
            throw new BadRequestHttpException($error, 400);
        }

        if (1 == $post['type']['type']) {
            $reg = '/^[a-zA-Z\\\0-9\*\_\{\}\&]+$/';
            $error = '提示请输入正确的硬件ID格式';
            if (!preg_match($reg, preg_quote($post['content']))) {
                throw new BadRequestHttpException($error, 400);
            }

            // 第一种
            //2.1 HDAUDIO\开头硬件ID；比如：HDAUDIO\FUNC_01&VEN_10EC&DEV_0280&SUBSYS_102805A5&REV_1000，按&分隔符把字符串分成5部分。
            //HDAUDIO\FUNC_01&VEN_10EC&DEV_0280&SUBSYS_102805A5&REV_1000查询，如果有结果直接返回，没有进入下一步。
            //去掉第五部分，变成HDAUDIO\FUNC_01&VEN_10EC&DEV_0280&SUBSYS_102805A5查询，如果有结果直接返回，没有进入下一步。
            //去掉第四部分，变成HDAUDIO\FUNC_01&VEN_10EC&DEV_0280&REV_1000查询，如果有结果直接返回，没有进入下一步。
            //去掉第四，五部分，变成HDAUDIO\FUNC_01&VEN_10EC&DEV_0280查询，如果有结果直接返回，没有就退出，显示无结果。
            $inf_hid = new InfHid();
            $reg = '/^(HDAUDIO\\\)(\w)*/i';
            if (preg_match($reg, preg_quote($post['content']))) {
                $result = $inf_hid->HdaudioSearch($post['content']);
                var_dump('asfafds');
                die;
            }

            //2.2 PCI\开头硬件ID，比如：PCI\VEN_8086&DEV_0412&SUBSYS_05A51028&REV_06，按&分隔符把字符串分成4部分。
            //以PCI\VEN_8086&DEV_0412&SUBSYS_05A51028&REV_06查询，如果有结果直接返回，没有进入下一步。
            //去掉第四部分，变成PCI\VEN_8086&DEV_0412&SUBSYS_05A51028查询，如果有结果直接返回，没有进入下一步。
            //去掉第三部分，变成PCI\VEN_8086&DEV_0412&REV_06查询，如果有结果直接返回，没有进入下一步。
            //去掉第三，四部分，变成PCI\VEN_8086&DEV_0412查询，如果有结果直接返回，没有就退出，显示无结果。
            $reg = '/^(PCI\\\)(\w)*/i';
            if (preg_match($reg, preg_quote($post['content']))) {
            }

            //2.3 ACPI开头硬件ID，比如：ACPI\VEN_LEN&DEV_0068，做字符串替换查询数据。
            //ACPI\VEN_LEN&DEV_0068直接查询，如果有结果直接返回，没有进入下一步。
            //替换VEN_和&DEV_为空，形成ACPI\LEN0068查询，如果有结果直接返回，没有进入下一步。
            //再替换ACPI\为*，形成*LEN0068查询，如果有结果直接返回，没有就退出，显示无结果。
            //有可能输入的直接是第二步ACPI\LEN0068样式的硬件ID，直接从第二步开始即可。
            $reg = '/^(ACPI\\\)(\w)*/i';
            if (preg_match($reg, preg_quote($post['content']))) {
            }

            //2.4 USB\开头硬件ID，按&分隔，替换掉REV节再查询一次。
            //比如：USB\VID_04B4&PID_0823&REV_0101&MI_00，如果有结果直接返回，没有进入下一步。
            //替换掉&REV_0101这个节，形成USB\VID_04B4&PID_0823&MI_00查询，如果有结果直接返回，没有就退出，显示无结果。

            //比如USB\VID_138A&PID_0090&REV_0164，如果有结果直接返回，没有进入下一步。
            //替换掉&REV_0164这个节，形成USB\VID_138A&PID_0090查询，如果有结果直接返回，没有就退出，显示无结果。
            $reg = '/^(USB\\\)(\w)*/i';
            if (preg_match($reg, preg_quote($post['content']))) {
            }
        }

        die;
    }
}
