<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use common\models\system\SystemUser;

/**
 * @var yii\web\View
 * @var backend\models\SystemUser $model
 * @var yii\widgets\ActiveForm    $form
 */
$attributes = [
    'username' => [
        'type' => Form::INPUT_TEXT,
        'options' => ['placeholder' => 'Enter 账户...',
        'maxlength' => 255,
        'disabled' => $model->isNewRecord ? false : true,
    ], ],
    'password' => [
        'type' => Form::INPUT_PASSWORD,
        'options' => ['maxlength' => 255],
    ],
    'email' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 电子邮箱...', 'maxlength' => 255]],
    'mobile' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 手机号...', 'maxlength' => 11]],
    'status' => [
        'type' => Form::INPUT_DROPDOWN_LIST,
        'items' => SystemUser::getArrayStatus(),
        'options' => ['placeholder' => 'Enter 状态...'],
    ],
    'roles' => [
        'type' => Form::INPUT_RADIO_LIST,
        'items' => SystemUser::getArrayRole(),
    ],
];
?>

<div class="system-user-form">
<?php $form = ActiveForm::begin([
    'type' => ActiveForm::TYPE_HORIZONTAL,
    'id' => 'system-user-form',
    'enableAjaxValidation' => true,
    'enableClientValidation' => true,
]); ?>
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title">基础信息</h3>
        </div>
        <div class="panel-body">
        <?php echo Form::widget([
            'model' => $model,
            'form' => $form,
            'columns' => 1,
            'attributes' => $attributes,
        ]); ?>
        </div>
        <div class="panel-footer">
            <div class="form-group">
                <div class="col-sm-offset-0 col-sm-12">
                    <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success btn-lg btn-block' : 'btn btn-primary btn-lg btn-block']); ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
