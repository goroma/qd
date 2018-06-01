<?php

namespace backend\controllers\yangsen;

use Yii;
use backend\models\yangsen\CustomerDaily;
use backend\models\yangsen\CustomerAnalysis;
use backend\models\yangsen\CustomerDailySearch;
use backend\components\BaseAuthController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CustomerDailyController implements the CRUD actions for CustomerDaily model.
 */
class CustomerDailyController extends BaseAuthController
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
     * Lists all CustomerDaily models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CustomerDailySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single CustomerDaily model.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('view', ['model' => $model]);
        }
    }

    /**
     * Creates a new CustomerDaily model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate($customer_id = 0)
    {
        $model = new CustomerDaily();

        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            if ($model->morning_weight && $model->night_weight) {
                $model->weight_diff = $model->morning_weight - $model->night_weight;
            }
            if (($customer = $model->customer) != null && $model->morning_weight) {
                $model->weight_loss = $customer->weigth - $model->morning_weight;
            }

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $customers = CustomerAnalysis::getAllCustomersArray();

                return $this->render('create', [
                    'model' => $model,
                    'customers' => $customers,
                ]);
            }
        } else {
            if ($customer_id) {
                $model->customer_id = $customer_id;
            }
            $model->is_menstruation = 0;
            $model->is_bigu = 0;
            $model->is_stagnation = 0;
            $customers = CustomerAnalysis::getAllCustomersArray();

            return $this->render('create', [
                'model' => $model,
                'customers' => $customers,
            ]);
        }
    }

    /**
     * Updates an existing CustomerDaily model.
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
            if ($model->morning_weight && $model->night_weight) {
                $model->weight_diff = $model->morning_weight - $model->night_weight;
            }
            if (($customer = $model->customer) != null && $model->morning_weight) {
                $model->weight_loss = $customer->weigth - $model->morning_weight;
            }

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                $customers = CustomerAnalysis::getAllCustomersArray();

                return $this->render('update', [
                    'model' => $model,
                    'customers' => $customers,
                ]);
            }
        } else {
            $customers = CustomerAnalysis::getAllCustomersArray();

            return $this->render('update', [
                'model' => $model,
                'customers' => $customers,
            ]);
        }
    }

    /**
     * Deletes an existing CustomerDaily model.
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
     * Finds the CustomerDaily model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return CustomerDaily the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CustomerDaily::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
