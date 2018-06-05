<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var backend\models\driver\InfSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="inf-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'driver_id') ?>

    <?= $form->field($model, 'class') ?>

    <?= $form->field($model, 'driver_ver') ?>

    <?= $form->field($model, 'driver_original_pubtime') ?>

    <?php // echo $form->field($model, 'driver_pubtime') ?>

    <?php // echo $form->field($model, 'driver_provider') ?>

    <?php // echo $form->field($model, 'inf_name') ?>

    <?php // echo $form->field($model, 'inf_sha256') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
