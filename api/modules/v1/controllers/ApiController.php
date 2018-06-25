<?php

namespace api\modules\v1\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use common\models\Driver;
use common\models\InfHid;

/**
 * Controller API.
 */
class ApiController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\Driver';

    /**
     * 获取资源信息.
     */
    public function actionIndex()
    {
    }

    /**
     * 创建资源.
     */
    public function actionCreate()
    {
    }

    /**
     * 更新资源.
     */
    public function actionUpdate($id)
    {
    }

    /**
     * 删除资源.
     */
    public function actionDelete($id)
    {
    }

    public function actionView($id)
    {
    }

    protected function findModel($id)
    {
        $modelClass = $this->modelClass;
        if (($model = $modelClass::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('数据不存在.', 404);
        }
    }

    public function checkAccess($action, $model = null, $params = [])
    {
        // 检查用户能否访问 $action 和 $model
        // 访问被拒绝应抛出ForbiddenHttpException
        // var_dump($params);exit;
    }

    /**
     * 新增加路由.
     */
    public function actionSearch()
    {
        $os = '';
        $pf = '';
        $request = Yii::$app->request;
        Yii::$app->ApiCommon->verifyParamIsEmpty(['type', 'content'], $request);
        try {
            $post = Yii::$app->getRequest()->getBodyParams();
            if (!in_array($post['type'], [1, 2])) {
                $error = '请选择硬件ID或设备名称';
                throw new BadRequestHttpException($error, 400);
            }
            if (!isset($post['content']) || !$post['content']) {
                $error = '请输入需要搜索的内容';
                throw new BadRequestHttpException($error, 400);
            }

            $page = (!isset($post['page']) || ($post['page'] <= 0)) ? 1 : $post['page'];
            $page_size = (!isset($post['page_size']) || ($post['page_size'] <= 0)) ? 20 : $post['page_size'];


            if (isset($post['os']) && $post['os']) {
                $os = $post['os'];
            }

            if (isset($post['pf']) && $post['pf']) {
                $pf = $post['pf'];
            }

            $inf_hid = new InfHid();
            if (1 == $post['type']) {
                $reg = '/^[a-zA-Z\\\0-9\*\_\{\}\&]+$/';
                $error = '提示请输入正确的硬件ID格式';
                if (!preg_match($reg, preg_quote($post['content']))) {
                    throw new BadRequestHttpException($error, 400);
                }

                $result = $inf_hid->hidSearch($post['content'], $os, $pf, $page, $page_size);

                return ['data' => $result, 'message' => 'success'];
            } else {
                $result = $inf_hid->hidSearch($post['content'], $os, $pf, $page, $page_size, 2);

                return ['data' => $result, 'message' => 'success'];
            }
        } catch (\Exception $e) {
            throw new NotFoundHttpException($e->getMessage(), 404);
        }
    }

    public function actionSearchHash()
    {
        $request = Yii::$app->request;
        Yii::$app->ApiCommon->verifyParamIsEmpty(['hash'], $request);
        try {
            $post = Yii::$app->getRequest()->getBodyParams();
            $driver = new Driver();
            $result = $driver->driverSearchHash($post['hash']);

            return ['data' => $result, 'message' => 'success'];
        } catch (\Exception $e) {
            throw new NotFoundHttpException($e->getMessage(), 404);
        }
    }
}
