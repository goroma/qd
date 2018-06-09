<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\driver\Driver $model
 */

$this->title = $model->qd_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Driver'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="driver-view">
    <?= DetailView::widget([
        'model' => $model,
        'condensed' => false,
        'hover' => true,
        'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
        'buttons1' => Html::a(
            '<span class="glyphicon glyphicon-backward"></span>',
            Yii::$app->urlManager->createUrl(['driver/driver/index']
        ), ['title' => Yii::t('app', 'GoBack')]).
        ' {delete}',
        'panel' => [
            'heading' => $this->title,
            'type' => DetailView::TYPE_INFO,
        ],
        'attributes' => [
            'id',
            'qd_name',
            'qd_file_size',
            'qd_sha256',
            [
                'label' => '安装方式',
                'attribute' => 'qd_install_type',
                'value' => $model::$install_type[$model->qd_install_type],
            ],
            'qd_source',
            'qd_download_url:url',
            'rank',
            'language',
            'parameter',
            'note',
            'type',
            'qd_instruction:ntext',
            [
                'attribute' => 'driver_inf',
                'value' => implode(';', ArrayHelper::getColumn($model->infs, 'inf_name')) ,
            ],
            'driver_os',
            'created_at',
            'updated_at',
        ],
        'deleteOptions' => [
            'url' => ['delete', 'id' => $model->id],
        ],
        'enableEditMode' => true,
    ]) ?>

</div>
