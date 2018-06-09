<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\Select2;
use kartik\datecontrol\DateControl;

/**
 * @var yii\web\View $this
 * @var backend\models\driver\Driver $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="driver-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([

        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [

            'qd_name' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 包名称...', 'maxlength' => 255]],

            'qd_install_type' => [
                'type' => Form::INPUT_WIDGET,
                'label' => '安装方式',
                'widgetClass' => Select2::classname(),
                'options' => [
                    'data' => $model::$install_type,
                    'options' => [
                        'placeholder' => '请选择安装方式',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ],
            ],

            'rank' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 权重...']],

            'qd_file_size' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 大小...', 'maxlength' => 255]],

            'language' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 语言...', 'maxlength' => 255]],

            'type' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 类型...', 'maxlength' => 255]],

            'qd_sha256' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 哈希值...', 'maxlength' => 1024]],

            'qd_source' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 来源...', 'maxlength' => 1024]],

            'qd_download_url' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 下载地址...', 'maxlength' => 1024]],

            'parameter' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 参数...', 'maxlength' => 1024]],

            'note' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 备注...', 'maxlength' => 1024]],

            'qd_instruction' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter 说明...','rows' => 6]],

            'driver_inf' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 说明...', 'readOnly' => true]],

            'driver_os' => [
                'type' => Form::INPUT_WIDGET,
                'label' => '安装方式',
                'widgetClass' => Select2::classname(),
                'options' => [
                    'data' => $driver_os_model::$all_os_select,
                    'options' => [
                        'placeholder' => '请选择包操作系统',
                        'multiple' => true,
                    ],
                    'pluginOptions' => [
                        'allowClear' => true,
                    ],
                ],
            ],
        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );

    echo Html::a(Yii::t('app', 'Cancel'),
        ['driver/driver/index'],
        [
            'class' => 'btn btn-default',
            'style' => 'margin-left:10px',
        ]
    );
    ActiveForm::end(); ?>

</div>
