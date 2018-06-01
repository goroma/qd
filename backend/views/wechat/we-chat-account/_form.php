<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;

/*
 * @var yii\web\View $this
 * @var backend\models\wechat\WeChatAccount $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="we-chat-account-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'company_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 对应使用公司的ID...']],

            'app_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 微信账号名称...', 'maxlength' => 64]],

            'app_secret' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 微信账号名称...', 'maxlength' => 128]],

            'token' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 微信公众平台填写的token...', 'maxlength' => 128]],

            'original_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 微信公众账号原始ID...', 'maxlength' => 32]],

            'account_name' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 微信账号名称...', 'maxlength' => 64]],

            'encoding_ase_key' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 微信公众平台消息加密密钥...', 'maxlength' => 128]],

            //'oauth_domain' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 微信后台要填写的授权链接...', 'maxlength' => 255]],

            'head_picurl' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 微信账号图像...', 'maxlength' => 255]],

            'subscribe_reply' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 被关注时自动回复...', 'maxlength' => 255]],

            'nokeyword_reply' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 没有命中关键词自动回复...', 'maxlength' => 255]],
        ],
    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
