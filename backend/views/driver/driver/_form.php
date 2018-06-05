<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
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

            'qd_install_type' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 安装方式,0:未知,1:inf,2:exe...']],

            'rank' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 权重...']],

            'is_del' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 是否删除...']],

            'qd_instruction' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter 说明...','rows' => 6]],

            'created_at' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => DateControl::classname(),'options' => ['type' => DateControl::FORMAT_DATETIME]],

            'updated_at' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => DateControl::classname(),'options' => ['type' => DateControl::FORMAT_DATETIME]],

            'qd_name' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 包名称...', 'maxlength' => 255]],

            'qd_file_size' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 大小...', 'maxlength' => 255]],

            'language' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 语言...', 'maxlength' => 255]],

            'type' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 类型...', 'maxlength' => 255]],

            'qd_sha256' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 哈希值...', 'maxlength' => 1024]],

            'qd_source' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 来源...', 'maxlength' => 1024]],

            'qd_download_url' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 下载地址...', 'maxlength' => 1024]],

            'parameter' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 参数...', 'maxlength' => 1024]],

            'note' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 备注...', 'maxlength' => 1024]],

        ]

    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
