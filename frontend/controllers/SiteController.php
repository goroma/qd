<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;

use common\models\common\WeChat;
use common\models\common\Common;
use frontend\models\wechat\WeChatPay;
use frontend\models\wechat\WeChatAccount;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $session = Yii::$app->session;
        $session->open();

        //$account = WeChatAccount::getWeChatAccount(Yii::$app->request->get('account_id'));
        $account = WeChatAccount::getWeChatAccount(WeChatAccount::getCurrentWeChatAccount());
        $oauth = WeChat::getWeChatApp($account)->oauth;

        if (Common::isWeChatBrowser()) {
            if (empty($session->get('wechat_user'))) {
                $session->set('target_url', 'site/index');
                $oauth->redirect()->send();
            }

            $user = $session->get('wechat_user');
        }

        return $this->renderContent(null);
    }

    public function actionWeChatWebOauth()
    {
        $session = Yii::$app->session;
        $session->open();

        //$account = WeChatAccount::getWeChatAccount(Yii::$app->request->get('account_id'));
        $account = WeChatAccount::getWeChatAccount(WeChatAccount::getCurrentWeChatAccount());
        $oauth = WeChat::getWeChatApp($account)->oauth;

        $user = $oauth->user();

        $session->set('wechat_user', $user->toArray());
        $targetUrl = empty($session->get('target_url')) ? 'site/index' : $session->get('target_url');

        return $this->redirect([$targetUrl]);
    }
}
