<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\driver\Inf $model
 */

$this->title = $model->inf_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Infs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inf-view">

    <?= DetailView::widget([
        'model' => $model,
        'condensed' => false,
        'hover' => true,
        'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
        'buttons1' => Html::a(
            '<span class="glyphicon glyphicon-backward"></span>',
            Yii::$app->urlManager->createUrl(['driver/inf/index']
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
            'inf_name',
            'inf_sha256',
            'class',
            'driver_ver',
            'driver_original_pubtime',
            'driver_pubtime',
            'driver_provider',
            'created_at',
            'updated_at',
        ],
        'deleteOptions' => [
            'url' => ['delete', 'id' => $model->id],
        ],
        'enableEditMode' => true,
    ]) ?>

</div>
