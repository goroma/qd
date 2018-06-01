<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/*
 * @var yii\web\View $this
 * @var backend\models\wechat\WeChatAccountSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="we-chat-account-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <div class="row">
        <div class="col-sm-2">
            <?= $form->field($model, 'account_name') ?>
        </div>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Search'), [
                'class' => 'btn btn-primary',
                'style' => 'margin-top:24px',
            ]) ?>
            <?= Html::resetButton(Yii::t('app', 'Reset'), [
                'class' => 'btn btn-default',
                'style' => 'margin-top:24px',
            ]) ?>
        </div>
    </div>

    <?php // $form->field($model, 'id')?>

    <?php //$form->field($model, 'company_id')?>

    <?php //$form->field($model, 'account_name')?>

    <?php //$form->field($model, 'app_id')?>

    <?php //$form->field($model, 'app_secret')?>

    <?php // echo $form->field($model, 'token')?>

    <?php // echo $form->field($model, 'encoding_ase_key')?>

    <?php // echo $form->field($model, 'original_id')?>

    <?php // echo $form->field($model, 'oauth_domain')?>

    <?php // echo $form->field($model, 'head_picurl')?>

    <?php // echo $form->field($model, 'subscribe_reply')?>

    <?php // echo $form->field($model, 'nokeyword_reply')?>

    <?php // echo $form->field($model, 'is_verified')?>

    <?php // echo $form->field($model, 'created_at')?>

    <?php // echo $form->field($model, 'updated_at')?>

    <?php // echo $form->field($model, 'is_del')?>

    <?php ActiveForm::end(); ?>

</div>
