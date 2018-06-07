<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var backend\models\driver\InfHidSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="inf-hid-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-sm-2">
            <?= $form->field($model, 'driver_qd_name') ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($model, 'driver_inf_name') ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($model, 'hid_name') ?>
        </div>
        <div class="col-sm-2">
            <?= $form->field($model, 'hid') ?>
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
