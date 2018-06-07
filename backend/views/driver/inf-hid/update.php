<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\driver\InfHid $model
 */

$this->title = Yii::t('app', 'Update') . 'Inf 硬件ID: ' . $model->hid_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Inf Hids'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->hid_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="inf-hid-update">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
        'drivers' => $drivers,
        'infs' => $infs,
    ]) ?>

</div>
