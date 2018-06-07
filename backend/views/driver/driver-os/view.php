<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\driver\DriverOs $model
 */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Driver Os'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="driver-os-view">

    <?= DetailView::widget([
        'model' => $model,
        'condensed' => false,
        'hover' => true,
        'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
        'buttons1' => Html::a(
            '<span class="glyphicon glyphicon-backward"></span>',
            Yii::$app->urlManager->createUrl(['driver/driver-os/index']
        ), ['title' => Yii::t('app', 'GoBack')]).
        ' {delete}',
        'panel' => [
            'heading' => $this->title,
            'type' => DetailView::TYPE_INFO,
        ],
        'attributes' => [
            'id',
            'driver_id',
            [
                'label' => '包名称',
                'attribute' => 'driver_id',
                'value' => $model->driver->qd_name,
            ],
            'qd_os',
            'qd_pf',
            'created_at',
            'updated_at',
        ],
        'deleteOptions' => [
            'url' => ['delete', 'id' => $model->id],
        ],
        'enableEditMode' => true,
    ]) ?>

</div>
