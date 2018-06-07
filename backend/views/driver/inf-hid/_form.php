<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
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

            'driver_id' => [
                'type' => Form::INPUT_WIDGET,
                'label' => '包',
                'widgetClass' => Select2::classname(),
                'options'=>[
                    'data' => $drivers,
                    'options' => [
                        'id' => 'driver-id',
                        'placeholder' => '请选择包',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ],
            ],

            'inf_id' => [
                'label' => 'inf',
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => DepDrop::classname(),
                'options'=>[
                    'type' => DepDrop::TYPE_SELECT2,
                    'data'=> $infs,
                    'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
                    'pluginOptions' => [
                        'depends'=>['driver-id'],
                        'placeholder'=>'请选择inf',
                        'url'=>Url::to(['/driver/inf-hid/get-driver-inf'])
                    ],
                ],
            ],

            'hid_name' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 硬件名称...', 'maxlength' => 255]],

            'hid' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 硬件ID...', 'maxlength' => 255]],

        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );

    echo Html::a(Yii::t('app', 'Cancel'),
        ['driver/inf-hid/index'],
        [
            'class' => 'btn btn-default',
            'style' => 'margin-left:10px',
        ]
    );
    ActiveForm::end(); ?>

</div>
