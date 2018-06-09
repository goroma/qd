<?php

namespace backend\controllers\driver;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use backend\models\driver\Inf;
use backend\models\driver\Driver;
use backend\models\driver\DriverOs;
use backend\models\driver\DriverSearch;
use common\models\common\QdBass;

/**
 * DriverController implements the CRUD actions for Driver model.
 */
class DriverController extends Controller
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
     * Lists all Driver models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Driver();
        $searchModel = new DriverSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        //批量上传
        if(Yii::$app->request->isPost) {
            $data = \Yii::$app->request->post();
            $model->load($data);
            $file = UploadedFile::getInstance($model, 'driver_file');

            if (!isset($file->baseName)) {
                \Yii::$app->getSession()->setFlash('error', '请上传包信息！');
                return $this->redirect(['index']);
            }

            $filename = $file->tempName;
            try {
                $qd = new QdBass();
                $configs = $qd->readInfZip($filename);

                foreach ($configs as $data) {
                    $driver_model = new Driver();
                    $driver = $driver_model->insertData($data['qd_config']);
                    if (!$driver || is_string($driver)) {
                        \Yii::$app->getSession()->setFlash('error', $driver);
                        return $this->redirect(['index']);
                        continue;
                    }

                    if ($driver) {
                        $driver_os_model = new DriverOs();
                        $driver_os_model->insertData($driver, $data['qd_config']);;

                        $inf_model = new Inf();
                        $inf_model->insertData($driver, $data['qd_config']);
                    }
                }
            } catch (\Exception $e) {
                //\Yii::$app->getSession()->setFlash('error', '上传驱动包数据错误！');
                \Yii::$app->getSession()->setFlash('error', $e->getMessage());
                return $this->redirect(['index']);
            }
        }

        return $this->render('index', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Driver model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $os = [];
            foreach ($model->oses as $driver_os) {
                $os[] = $driver_os->qd_os.'-'.$driver_os->qd_pf;
            }
            $model->driver_os = implode(';', $os);

            return $this->render('view', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Creates a new Driver model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Driver;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Driver model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $driver_os_model = new DriverOs;

        if ($model->load(Yii::$app->request->post())) {
            DriverOs::delOsByDriver($model);
            $driver_os_model->saveOs($model);
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $os = [];
            foreach ($model->oses as $driver_os) {
                $os[] = $driver_os->qd_os.'-'.$driver_os->qd_pf;
            }
            $options = $driver_os_model::$all_os_select;

            $model->driver_os = array_map(function ($option) use ($options) {
                return array_search($option, $options);
            }, $os);

            $model->driver_inf = implode(';', ArrayHelper::getColumn($model->infs, 'inf_name'));
            return $this->render('update', [
                'model' => $model,
                'driver_os_model' => $driver_os_model,
            ]);
        }
    }

    /**
     * Deletes an existing Driver model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Driver model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Driver the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Driver::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
