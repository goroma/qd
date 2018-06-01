<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/*
 * @var yii\web\View $this
 * @var backend\models\wechat\WeChatCommunication $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="we-chat-communication-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'communication_openid' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 用户openid...', 'maxlength' => 32]],

            'company_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 公司的ID...']],

            'wechat_account_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 微信账号ID...']],

            'communication_staff_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 处理人ID...']],

            'communication_is_top' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 是否置顶...']],

            'communication_content_type' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 消息类型...']],

            'communication_operation_status' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 消息状态...']],

            'is_del' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 是否删除...']],

            'created_at' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => DateControl::classname(), 'options' => ['type' => DateControl::FORMAT_DATETIME]],

            'updated_at' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => DateControl::classname(), 'options' => ['type' => DateControl::FORMAT_DATETIME]],
        ],
    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
