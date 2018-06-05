<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\driver\InfHid $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="inf-hid-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'driver_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 包ID...']],

            'inf_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter inf ID...']],

            'created_at' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => DateControl::classname(),'options' => ['type' => DateControl::FORMAT_DATETIME]],

            'updated_at' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => DateControl::classname(),'options' => ['type' => DateControl::FORMAT_DATETIME]],

            'hid_name' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 硬件名称...', 'maxlength' => 255]],

            'hid' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 硬件ID...', 'maxlength' => 255]],

        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
