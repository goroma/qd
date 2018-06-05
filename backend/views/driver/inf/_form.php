<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\driver\Inf $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="inf-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'driver_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 包ID...']],

            'driver_pubtime' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => DateControl::classname(),'options' => ['type' => DateControl::FORMAT_DATE]],

            'created_at' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => DateControl::classname(),'options' => ['type' => DateControl::FORMAT_DATETIME]],

            'updated_at' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => DateControl::classname(),'options' => ['type' => DateControl::FORMAT_DATETIME]],

            'class' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 驱动类型...', 'maxlength' => 255]],

            'driver_ver' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 版本...', 'maxlength' => 255]],

            'driver_original_pubtime' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 发布时间(未处理)...', 'maxlength' => 255]],

            'driver_provider' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 驱动供应商...', 'maxlength' => 255]],

            'inf_name' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter inf名称...', 'maxlength' => 255]],

            'inf_sha256' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 哈希值...', 'maxlength' => 1024]],

        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
