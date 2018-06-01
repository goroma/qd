<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;

/*
 * @var yii\web\View $this
 * @var backend\models\wechat\WeChatQrcode $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="we-chat-qrcode-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'company_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 对应使用公司的ID...']],

            'wechat_account_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 使用的微信账号ID...']],

            'qrcode_type' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => 'kartik\widgets\Select2',
                'options' => ['data' => $model::$qrcodeTypeMap],
                'hint' => '请选择二维码类型',
            ],

            'expire_seconds' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 临时二维码有效秒数...']],

            'scene_key' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 临时|永久二维码场景值...', 'maxlength' => 64]],
        ],
    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
