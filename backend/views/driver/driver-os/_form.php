<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\Select2;
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

            'driver_id' => [
                'type' => Form::INPUT_WIDGET,
                'label' => '包名称',
                'widgetClass' => Select2::classname(),
                'options' => [
                    'data' => $drivers,
                    'options' => [
                        'placeholder' => '请选择包',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ],
            ],

            'qd_os' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 操作系统...', 'maxlength' => 255]],

            'qd_pf' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 平台...', 'maxlength' => 32]],

        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );

    echo Html::a(Yii::t('app', 'Cancel'),
        ['driver/driver-os/index'],
        [
            'class' => 'btn btn-default',
            'style' => 'margin-left:10px',
        ]
    );
    ActiveForm::end(); ?>

</div>
