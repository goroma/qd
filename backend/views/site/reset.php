<?php
use yii\helpers\Html;
use yii\captcha\Captcha;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = Yii::t('app', 'Reset Password');

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>",
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>",
];

$fieldOptions3 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-warning-sign form-control-feedback'></span>",
];
?>

<div class="login-box">
    <div class="login-logo">
        <a href="#"><b><?php echo Yii::t('app', 'Reset Password') ?></b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg"><?php echo Yii::t('app', 'Reset Password') ?></p>

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

        <?= $form
            ->field($model, 'password', $fieldOptions2)
            ->label(false)
            ->passwordInput(['placeholder' => Yii::t('app', 'Password')])
        ?>

        <?= $form
            ->field($model, 'repassword', $fieldOptions2)
            ->label(false)
            ->passwordInput(['placeholder' => Yii::t('app', 'Repassword')])
        ?>

        <?= $form
        ->field($model, 'verify_code', $fieldOptions3)
        ->label(false)
        ->widget(Captcha::className(), ['template' => '<div class="row"><div class="col-lg-4">{image}</div><div class="col-lg-8">{input}</div></div>'])
        ?>

        <div class="row">
            <div class="col-xs-4">
                <?= Html::submitButton(Yii::t('app', 'Confirm'), ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
        </div>


        <?php ActiveForm::end(); ?>
    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
