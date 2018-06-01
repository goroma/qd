<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;

/*
 * @var yii\web\View $this
 * @var backend\models\wechat\WeChatMenu $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="we-chat-menu-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            //'company_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 对应使用公司的ID...']],

            //'wechat_account_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 使用的微信账号ID...']],

            //'menu_pid' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 菜单父级ID...']],

            'menu_type' => [
                'type' => Form::INPUT_WIDGET,
                'widgetClass' => 'kartik\widgets\Select2',
                'options' => ['data' => $model::$menuTypeMap],
                'hint' => '请选择自定义菜单类型',
            ],

            'menu_name' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 菜单名称...', 'maxlength' => 40]],
            'key' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 菜单KEY值...', 'maxlength' => 128]],

            'url' => ['type' => Form::INPUT_TEXTAREA, 'options' => ['placeholder' => 'Enter 网页链接...', 'rows' => 2]],

            //'media_id' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 图片或图文菜单所需media_id...', 'maxlength' => 255]],
        ],
    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
