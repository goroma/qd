<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use common\models\LoginForm;

/**
 * Site controller.
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                //'only' => ['login', 'logout', 'reset-password'],
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'reset-password', 'captcha'],
                        'allow' => true,
                        //'roles' => ['?']
                    ],
                    [
                        'actions' => ['logout', 'index', 'reset-password'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
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
                //'backColor'=>0x000000,//背景颜色
                'maxLength' => 4, //最大显示个数
                'minLength' => 4, //最少显示个数
                //'padding' => 9,//间距
                //'height'=>40,//高度
                //'width' => 130,  //宽度
                //'foreColor'=>0xffffff,     //字体颜色
                'offset' => 4,        //设置字符偏移量 有效果
                //'controller'=>'login',        //拥有这个动作的controller
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        $model->scenario = 'login';

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * 重置密码.
     */
    public function actionResetPassword($token)
    {
        $model = new LoginForm();
        $model->scenario = 'reset';

        $post = Yii::$app->request->post();
        if ($model->load($post) && $model->validate()) {
            $model->token = $token;
            if ($model->resetPassword()) {
                return $this->redirect('login');
            } else {
                return $this->render('reset', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render('reset', [
                'model' => $model,
            ]);
        }
    }
}
