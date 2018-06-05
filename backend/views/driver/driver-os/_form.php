<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\driver\DriverOs $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="driver-os-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'driver_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 包ID...']],

            'created_at' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => DateControl::classname(),'options' => ['type' => DateControl::FORMAT_DATETIME]],

            'updated_at' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => DateControl::classname(),'options' => ['type' => DateControl::FORMAT_DATETIME]],

            'qd_os' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 操作系统...', 'maxlength' => 255]],

            'qd_pf' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 平台...', 'maxlength' => 32]],

        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
