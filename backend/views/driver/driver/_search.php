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

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'qd_name') ?>

    <?= $form->field($model, 'qd_file_size') ?>

    <?= $form->field($model, 'qd_sha256') ?>

    <?= $form->field($model, 'qd_install_type') ?>

    <?php // echo $form->field($model, 'qd_source') ?>

    <?php // echo $form->field($model, 'qd_download_url') ?>

    <?php // echo $form->field($model, 'qd_instruction') ?>

    <?php // echo $form->field($model, 'rank') ?>

    <?php // echo $form->field($model, 'language') ?>

    <?php // echo $form->field($model, 'parameter') ?>

    <?php // echo $form->field($model, 'note') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'is_del') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
