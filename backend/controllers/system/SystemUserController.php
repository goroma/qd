<?php

namespace backend\controllers\system;

use Yii;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\bootstrap\ActiveForm;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use common\models\system\SystemUser;
use common\models\system\SystemUserSearch;
use backend\components\BaseAuthController;

/**
 * SystemUserController implements the CRUD actions for SystemUser model.
 */
class SystemUserController extends BaseAuthController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all SystemUser models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        if (\Yii::$app->user->can('system_user_manager')) {
            $searchModel = new SystemUserSearch();
            $query = Yii::$app->request->getQueryParams();
            $dataProvider = $searchModel->search($query);

            return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]);
        } else {
            throw new ForbiddenHttpException('没有访问权限！');
        }
    }

    /**
     * Displays a single SystemUser model.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', ['model' => $model]);
    }

    /**
     * Creates a new SystemUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SystemUser();
        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            if (Yii::$app->request->isAjax && 'system-user-form' == $post['ajax']) {
                Yii::$app->response->format = Response::FORMAT_JSON;

                return ActiveForm::validate($model, ['username', 'email', 'mobile']);
            }
            if (!$model->save()) {
                return $this->render('create', [
                    'model' => $model,
                ]);
            }

            $model->saveRoles();

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SystemUser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $post = Yii::$app->request->post();

        if ($model->load($post)) {
            if (Yii::$app->request->isAjax && 'system-user-form' == $post['ajax']) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                if ($model::validateMobile($model)) {
                    return [
                        'systemuser-mobile' => [
                            ['手机号已存在'],
                        ],
                    ];
                }
                if ($model::validateEmail($model)) {
                    return [
                        'systemuser-email' => [
                            ['邮箱已存在'],
                        ],
                    ];
                }

                return [];
            }
            if (!$model->save()) {
                return $this->render('update', ['model' => $model]);
            }

            $model->saveRoles();

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', ['model' => $model]);
    }

    /**
     * Deletes an existing SystemUser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SystemUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return SystemUser the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SystemUser::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * 修改个人资料.
     */
    public function actionUpdateProfile()
    {
        $id = \Yii::$app->user->id;
        $model = $this->findModel($id);
        $post = Yii::$app->request->post();

        if ($model->load($post)) {
            if (Yii::$app->request->isAjax && 'system-update-profile-form' == $post['ajax']) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                if ($model::validateMobile($model)) {
                    return [
                        'systemuser-mobile' => [
                            ['手机号已存在'],
                        ],
                    ];
                }
                if ($model::validateEmail($model)) {
                    return [
                        'systemuser-email' => [
                            ['邮箱已存在'],
                        ],
                    ];
                }

                return [];
            }

            if (!$model->save()) {
                return $this->render('update_profile', [
                    'model' => $model,
                ]);
            }
            \Yii::$app->session->setFlash('default', '修改成功');

            return $this->redirect(['update-profile', 'id' => $model->id]);
        }

        return $this->render('update_profile', [
            'model' => $model,
        ]);
    }
}
