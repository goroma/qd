<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\driver\DriverOs $model
 */

$this->title = Yii::t('app', 'Create').Yii::t('app', 'Driver Os');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Driver Os'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="driver-os-create">
    <div class="page-header">
        <h4><?= Html::encode($this->title) ?></h4>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
        'drivers' => $drivers,
    ]) ?>

</div>
