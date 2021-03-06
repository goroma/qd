<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var backend\models\driver\DriverSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="driver-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-sm-2">
            <?= $form->field($model, 'id') ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($model, 'qd_name') ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($model, 'type') ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($model, 'qd_download_url') ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($model, 'qd_sha256') ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Search'), [
                'class' => 'btn btn-primary',
                'style' => 'margin-top:24px',
            ]) ?>
            <?= Html::resetButton(Yii::t('app', 'Reset'), [
                'class' => 'btn btn-default',
                'style' => 'margin-top:24px',
            ]) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
