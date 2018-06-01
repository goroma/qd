<?php
namespace frontend\controllers\wechat;

use Yii;
use yii\web\Response;
use yii\rest\Controller;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\auth\HttpBearerAuth;

use common\models\common\WeChat;
use common\models\common\Common;
use frontend\models\wechat\WeChatPay;
use frontend\models\wechat\WeChatAccount;

/**
 * WeChat controller
 */
class WeChatController extends Controller
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

    /**
     * 生成调用微信支付JSSDK所需要的配置信息.
     */
    public function actionWeChatPayConfig()
    {
        $account = WeChatAccount::getWeChatAccount(WeChatAccount::getCurrentWeChatAccount());

        $account->app_id = Yii::$app->params['wechatPay']['app_id'];
        $account->app_secret = Yii::$app->params['wechatPay']['secret'];
        $account->token = Yii::$app->params['wechatPay']['token'];
        $app = WeChat::getWeChatApp($account);

        //$payment = $app->payment;
        $js = $app->js;

        //$order = WeChatPay::createWeChatOrder();
        //$result = $payment->prepare($order);
        //if ($result->return_code == 'SUCCESS' && $result->result_code == 'SUCCESS'){

            return [
                'jsconfig' => $js->config(['chooseWXPay'], true, false, false),
                //'payconfig' => $payment->configForJSSDKPayment($result->prepay_id),
            ];

            //return $payment->configForJSSDKPayment($result->prepay_id);
        //} else {
            //return ['code' => 0, 'msg' => 'error'];
        //}
    }
}
