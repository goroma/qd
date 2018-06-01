<?php

namespace api\components;

use Yii;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

abstract class BaseController extends ActiveController
{
    /**
     * 分页配置.
     */
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    /**
     * 验证.
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
            //'authMethods' => [
                //HttpBasicAuth::className(),
                //HttpBearerAuth::className(),
                //QueryParamAuth::className(),
            //],
            // 可选参数 修改默认的 `access-token`
            'tokenParam' => 'access_token',
        ];

        return $behaviors;
    }

    /**
     * 接口请求前操作.
     * 1.记录日志
     * 2.校验.
     */
    public function beforeAction($action)
    {
        // 记录日志
        $request = Yii::$app->request;
        $logger = Yii::$app->monolog->getLogger('api');
        $logger->log('info', $request->pathInfo.' Method: '.$request->method, ($request->isGet ? $request->get() : $request->bodyParams));

        // 验证 @TODO

        return parent::beforeAction($action);
    }

    /**
     * 注销系统自带的实现方法.
     */
    public function actions()
    {
        $actions = parent::actions();

        // 注销系统自带的实现方法
        unset($actions['index'], $actions['update'], $actions['create'], $actions['delete'], $actions['view']);

        return $actions;
    }

    /**
     * 接口请求后操作.
     * 1.规范数据返回格式.
     */
    public function afterAction($action, $result)
    {
        $response = parent::afterAction($action, $result);

        //$logger = Yii::$app->monolog->getLogger('api');
        //$logger->log('info', 'Return: ', $response);

        if (isset($response['code']) && 200 == $response['code']) {
            return $response;
        } else {
            return ['code' => 200, 'message' => '请求成功!', 'data' => $response];
        }
    }

    /**
     * 规范返回格式.
     */
    public function formatterResponse($data = [], $message = '成功!', $code = 200)
    {
        return [
            'code' => $code,
            'message' => $message,
            'data' => $data,
        ];
    }

    /**
     * 生成sign.
     */
    private function _genSign($data)
    {
        $arr = array();
        $arr['body'] = $data['body'];
        $arr['secret'] = Yii::$app->params['secret'];
        $this->_arraySort($arr);
        $str = json_encode($arr);
        $sign = strtoupper(md5($str));

        return $sign;
    }

    /**
     * 数组排序.
     */
    private function _arraySort(&$arr)
    {
        ksort($arr);
        foreach ($arr as &$v) {
            if (is_array($v)) {
                $this->_arraySort($v);
            }
        }

        return true;
    }

    abstract public function actionIndex();

    abstract public function actionCreate();

    abstract public function actionUpdate($id);

    abstract public function actionDelete($id);
}
