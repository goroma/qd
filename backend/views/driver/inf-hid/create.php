<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\driver\InfHid $model
 */

$this->title = Yii::t('app', 'Create').'Inf 硬件ID';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Inf Hids'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inf-hid-create">
    <div class="page-header">
        <h4><?= Html::encode($this->title) ?></h4>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
        'drivers' => $drivers,
        'infs' => $infs,
    ]) ?>

</div>
