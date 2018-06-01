<?php

use yii\helpers\Html;
use kartik\builder\Form;
use kartik\widgets\Select2;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;

/*
 * @var yii\web\View $this
 * @var backend\models\yangsen\CustomerDaily $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="customer-daily-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'customer_id' => [
                'type' => Form::INPUT_WIDGET,
                'label' => '客户',
                'widgetClass' => Select2::classname(),
                'options' => [
                    'data' => $customers,
                    'options' => [
                        'placeholder' => '请选择客户名称',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ],
            ],

            'is_menstruation' => [
                'items' => $model::$yesorno,
                'type' => Form::INPUT_RADIO_LIST,
                'options' => ['inline' => true],
            ],

            'is_bigu' => [
                'items' => $model::$yesorno,
                'type' => Form::INPUT_RADIO_LIST,
                'options' => ['inline' => true],
            ],

            'is_stagnation' => [
                'items' => $model::$yesorno,
                'type' => Form::INPUT_RADIO_LIST,
                'options' => ['inline' => true],
            ],

            'used_at' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => DateControl::classname(),
                'options' => [
                    'type' => DateControl::FORMAT_DATE,
                    'widgetOptions' => [
                        'pluginOptions' => [
                            'autoclose' => true,
                            'todayHighlight' => true,
                        ],
                    ],
                ],
            ],

            'breakfast' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '请输入早餐...', 'maxlength' => 255]],

            'lunch' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '请输入午餐...', 'maxlength' => 255]],

            'afternoon_tea' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '请输入下午茶...', 'maxlength' => 255]],

            'dinner' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '请输入晚餐...', 'maxlength' => 255]],

            'morning_weight' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '请输入早上体重...', 'maxlength' => 5]],

            'night_weight' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '请输入晚上体重...', 'maxlength' => 5]],

            'weight_diff' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '不用填写，自动计算', 'maxlength' => 5, 'readonly' => true]],

            'weight_loss' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '不用填写，自动计算', 'maxlength' => 5, 'readonly' => true]],
        ],
    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    echo Html::a(Yii::t('app', 'Cancel'),
        ['yangsen/customer-daily/index'],
        [
            'class' => 'btn btn-default',
            'style' => 'margin-left:10px',
        ]
    );
    ActiveForm::end(); ?>

</div>
