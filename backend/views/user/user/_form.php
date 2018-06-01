<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;

/*
 * @var yii\web\View $this
 * @var backend\models\user\User $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['type' => ActiveForm::TYPE_HORIZONTAL]); echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'status' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 状态...']],

            'mobile' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 手机号...', 'maxlength' => 11]],

            'localimgurl' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 本地头像...', 'maxlength' => 255]],

            'email' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 邮箱...', 'maxlength' => 255]],

            'classify' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 用户分类...']],

            'role' => ['type' => Form::INPUT_TEXT, 'options' => ['placeholder' => 'Enter 角色...']],
        ],
    ]);

    echo Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
        ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
    );
    ActiveForm::end(); ?>

</div>
