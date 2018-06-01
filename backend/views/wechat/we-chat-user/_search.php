<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

/*
 * @var yii\web\View $this
 * @var backend\models\wechat\WeChatUserSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="we-chat-user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">

        <div class="col-sm-2">
            <?= $form->field($model, 'nickname') ?>
        </div>

        <div class="col-sm-2">
            <?= $form->field($model, 'openid') ?>
        </div>

        <div class="col-sm-2">
            <?php echo $form->field($model, 'gender')->label('性别')->widget(Select2::classname(), [
                'data' => $model::$genderMap,
                'options' => ['placeholder' => '请选择性别'],
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]); ?>
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

    <?php //$form->field($model, 'company_id')?>

    <?php //$form->field($model, 'wechat_account_id')?>

    <?php //$form->field($model, 'openid')?>

    <?php //$form->field($model, 'unionid')?>

    <?php // echo $form->field($model, 'groupid')?>

    <?php // echo $form->field($model, 'nickname')?>

    <?php // echo $form->field($model, 'country')?>

    <?php // echo $form->field($model, 'province')?>

    <?php // echo $form->field($model, 'city')?>

    <?php // echo $form->field($model, 'gender')?>

    <?php // echo $form->field($model, 'language')?>

    <?php // echo $form->field($model, 'headimgurl')?>

    <?php // echo $form->field($model, 'localimgurl')?>

    <?php // echo $form->field($model, 'subscribe')?>

    <?php // echo $form->field($model, 'subscribe_time')?>

    <?php // echo $form->field($model, 'unsubscribe_time')?>

    <?php // echo $form->field($model, 'lastest_communication_time')?>

    <?php // echo $form->field($model, 'remark')?>

    <?php // echo $form->field($model, 'created_at')?>

    <?php // echo $form->field($model, 'updated_at')?>

    <?php // echo $form->field($model, 'is_del')?>

    <?php ActiveForm::end(); ?>

</div>
