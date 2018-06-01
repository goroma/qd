<?php

namespace api\modules\v2\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

/**
 * Country Controller API
 */
class CountryController extends ActiveController
{
    public $modelClass = 'api\modules\v2\models\Country';

    /**
     * 验证.
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                HttpBasicAuth::className(),
                HttpBearerAuth::className(),
                QueryParamAuth::className(),
            ],
        ];

        return $behaviors;
    }

    /**
     * 注销系统自带的实现方法
     */
    public function actions()
    {
        $actions = parent::actions();

        // 注销系统自带的实现方法
        unset($actions['index'], $actions['update'], $actions['create'], $actions['delete'], $actions['view']);
        return $actions;
    }

    /**
     * 获取资源信息
     */
    public function actionIndex()
    {
        $modelClass = $this->modelClass;
        $query = $modelClass::find();
        return new ActiveDataProvider([
            'query' => $query
        ]);
    }

    /**
     * 创建资源
     */
    public function actionCreate()
    {
        $model = new $this->modelClass();
        $model->attributes = Yii::$app->request->post();
        if (! $model->save()) {
            $err = $model->getFirstErrors();
            return $err;
        }
        return $model;
    }

    /**
     * 更新资源
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->attributes = Yii::$app->request->post();
        if (! $model->save()) {
            $err = $model->getFirstErrors();
            return $err;
        }
        return $model;
    }

    /**
     * 删除资源
     */
    public function actionDelete($id)
    {
        return $this->findModel($id)->delete();
    }

    public function actionView($id)
    {
        return $this->findModel($id);
    }

    protected function findModel($id)
    {
        $modelClass = $this->modelClass;
        if (($model = $modelClass::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
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
