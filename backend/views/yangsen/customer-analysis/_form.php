<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\Select2;
use kartik\datecontrol\DateControl;

/*
 * @var yii\web\View $this
 * @var backend\models\yangsen\CustomerAnalysis $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="customer-analysis-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'name' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '请输入名称...', 'maxlength' => 255]],

            'age' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '请输入年龄...']],

            'gender' => [
                'type' => Form::INPUT_WIDGET,
                'label' => '性别',
                'widgetClass' => Select2::classname(),
                'options' => [
                    'data' => $model::$genderMap,
                    'options' => [
                        'placeholder' => '请选择客户性别',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ],
            ],

            'customer_type' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => Select2::classname(),
                'options' => [
                    'data' => $model::$types,
                    'options' => [
                        'placeholder' => '请选择客户类型',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ],
            ],

            'target' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => Select2::classname(),
                'options' => [
                    'data' => $model::$targets,
                    'options' => [
                        'placeholder' => '请选择使用对象',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ],
            ],

            'physical_state' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => Select2::classname(),
                'options' => [
                    'data' => $model::$states,
                    'options' => [
                        'placeholder' => '请选择身体状态',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ],
            ],

            'purchasing_power' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => Select2::classname(),
                'options' => [
                    'data' => $model::$levels,
                    'options' => [
                        'placeholder' => '请选择购买力等级',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ],
            ],

            'height' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '请输入身高...', 'maxlength' => 5]],

            'weigth' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '请输入体重...', 'maxlength' => 5]],

            'occupation' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '请输入职业...', 'maxlength' => 255]],

            'consulting_time' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => DateControl::classname(),
                'options' => [
                    'type' => DateControl::FORMAT_DATETIME,
                    'widgetOptions' => [
                        'pluginOptions' => [
                            'autoclose' => true,
                            'todayHighlight' => true,
                        ],
                    ],
                ],
            ],

            'consulting_number' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '请输入咨询次数...']],

            'disease' => [
                'items' => $model::$yesorno,
                'type' => Form::INPUT_RADIO_LIST,
                'options' => ['inline' => true],
            ],

            'disease_desc' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '请输入疾病史描述...', 'maxlength' => 255]],

            'remark' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => '请输入备注...', 'maxlength' => 255]],
        ],
    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );

    echo Html::a(Yii::t('app', 'Cancel'),
        ['yangsen/customer-analysis/index'],
        [
            'class' => 'btn btn-default',
            'style' => 'margin-left:10px',
        ]
    );
    ActiveForm::end(); ?>

</div>
