<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;

/*
 * @var yii\web\View $this
 * @var backend\models\wechat\WeChatUser $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="we-chat-user-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'created_at' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => DateControl::classname(), 'options' => ['type' => DateControl::FORMAT_DATETIME]],

            'updated_at' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => DateControl::classname(), 'options' => ['type' => DateControl::FORMAT_DATETIME]],

            'company_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 对应使用公司的ID...']],

            'wechat_account_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 使用的微信账号ID...']],

            'groupid' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 微信用户所在分组ID...']],

            'gender' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 性别，0:未知,1:男,2:女...']],

            'subscribe' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 是否关注,1关注;0未关注...']],

            'is_del' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 是否逻辑删除...']],

            'subscribe_time' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => DateControl::classname(), 'options' => ['type' => DateControl::FORMAT_DATETIME]],

            'unsubscribe_time' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => DateControl::classname(), 'options' => ['type' => DateControl::FORMAT_DATETIME]],

            'lastest_communication_time' => ['type' => Form::INPUT_WIDGET, 'widgetClass' => DateControl::classname(), 'options' => ['type' => DateControl::FORMAT_DATETIME]],

            'remark' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter 公众号对用户备注...', 'rows' => 6]],

            'openid' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 微信用户openid...', 'maxlength' => 64]],

            'unionid' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 微信用户unionid...', 'maxlength' => 64]],

            'nickname' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 微信用户昵称...', 'maxlength' => 64]],

            'country' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 国家...', 'maxlength' => 64]],

            'province' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 省份...', 'maxlength' => 64]],

            'city' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 城市...', 'maxlength' => 64]],

            'language' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 微信用户的语言...', 'maxlength' => 12]],

            'headimgurl' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 微信用户头像图片链接...', 'maxlength' => 245]],

            'localimgurl' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 微信用户头像本地图片链接...', 'maxlength' => 245]],
        ],
    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
