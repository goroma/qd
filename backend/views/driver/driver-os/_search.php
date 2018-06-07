<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

/**
 * @var yii\web\View $this
 * @var backend\models\driver\DriverOsSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="driver-os-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-sm-2">
            <?= $form->field($model, 'driver_qd_name') ?>
        </div>

        <div class="col-sm-2">
            <?php echo $form->field($model, 'qd_os')->widget(Select2::classname(), [
                'data' => $model::$all_os,
                'options' => ['placeholder' => '请选择操作系统'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]); ?>
        </div>

        <div class="col-sm-2">
            <?php echo $form->field($model, 'qd_pf')->widget(Select2::classname(), [
                'data' => [32 => '32位', 64 => '64位'],
                'options' => ['placeholder' => '请选择平台'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]); ?>
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
