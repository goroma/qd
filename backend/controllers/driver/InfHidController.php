<?php

namespace backend\controllers\driver;

use Yii;
use backend\models\driver\InfHid;
use backend\models\driver\Driver;
use backend\models\driver\InfHidSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * InfHidController implements the CRUD actions for InfHid model.
 */
class InfHidController extends Controller
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
     * Lists all InfHid models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new InfHidSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single InfHid model.
     * @param integer $id
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
     * Creates a new InfHid model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new InfHid;
        $drivers = Driver::getAllDriverArray();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $infs = [];
            return $this->render('create', [
                'model' => $model,
                'drivers' => $drivers,
                'infs' => $infs,
            ]);
        }
    }

    /**
     * Updates an existing InfHid model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $drivers = Driver::getAllDriverArray();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $infs = [];
            $driver = $model->driver;
            $infs = ArrayHelper::map($driver->infs, 'id', 'inf_name');

            return $this->render('update', [
                'model' => $model,
                'drivers' => $drivers,
                'infs' => $infs,
            ]);
        }
    }

    /**
     * Deletes an existing InfHid model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the InfHid model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InfHid the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InfHid::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGetDriverInf()
    {
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $post = Yii::$app->request->post('depdrop_parents');
            if ($post != null && $post[0] && !isset($post[1])) {
                $driver_id = $post[0];
                $driver = Driver::findOne($driver_id);
                $infs = $driver->infs;

                $infs = ArrayHelper::map($infs, 'id', 'inf_name');

                foreach ($infs as $id => $inf_name) {
                    $out[$id]['id'] = $id;
                    $out[$id]['name'] = $inf_name;
                }

                echo Json::encode(['output' => $out, 'selected' => '']);

                return;
            }
        }

        echo Json::encode(['output' => '', 'selected' => '']);
    }
}
