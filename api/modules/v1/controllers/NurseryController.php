<?php

namespace api\modules\v1\controllers;

use Yii;
use api\components\BaseController;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use common\models\common\Qiniu;
use common\models\nursery\NurseryPic;

/**
 * Nursery Controller API.
 */
class NurseryController extends BaseController
{
    public $modelClass = 'api\modules\v1\models\Nursery';

    /**
     * 获取资源信息.
     */
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $accessToken = $request->get('access_token');

        $modelClass = $this->modelClass;

        return $modelClass::getNurseryList($accessToken);
    }

    /**
     * 创建资源.
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $accessToken = $request->get('access_token');
        Yii::$app->ApiCommon->verifyParamIsEmpty(['nursery_name', 'province_id', 'city_id', 'county_id', 'nursery_address'], $request);

        $model = new $this->modelClass();
        $model->attributes = $request->post();

        $nursery = $model::saveNursery($model, $accessToken);
        if ($nursery && isset($_FILES['nursery_logo']) && file_exists($_FILES['nursery_logo']['tmp_name'])) {
            if (($picurl = Qiniu::uploadToQiniu($_FILES['nursery_logo']['tmp_name']))) {
                $image = new NurseryPic();
                $image->nursery_pic = $picurl;
                $image->nursery_pic_type = $model::LOGO;
                $image->link('nursery', $nursery);
                if (!$image->save()) {
                    $err = $model->getFirstErrors();
                    foreach ($err as $name => $message) {
                        throw new BadRequestHttpException($name.$message, 400);
                    }
                }

                $nursery->nursery_logo = $picurl;
            }
        }

        return $this->formatterResponse(['items' => $nursery], '机构创建成功!');
    }

    /**
     * 更新资源.
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->attributes = Yii::$app->request->post();
        if (!$model->save()) {
            $err = $model->getFirstErrors();

            return $err;
        }

        return $model;
    }

    /**
     * 删除资源.
     */
    public function actionDelete($id)
    {
        return $this->findModel($id)->delete();
    }

    public function actionView($id)
    {
        $result = $this->findModel($id);

        return $this->formatterResponse(['items' => $result], '请求成功!');
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
        return ['test'];
    }
}
