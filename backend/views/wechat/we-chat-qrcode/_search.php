<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

/*
 * @var yii\web\View $this
 * @var backend\models\wechat\WeChatQrcodeSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="we-chat-qrcode-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php //$form->field($model, 'company_id')?>

    <?php //$form->field($model, 'wechat_account_id')?>

    <?php //$form->field($model, 'scene_key')?>
    <div class="row">

        <div class="col-sm-2">
            <?= $form->field($model, 'scene_key') ?>
        </div>

        <div class="col-sm-2">
            <?php echo $form->field($model, 'qrcode_type')->label('二维码类型')->widget(Select2::classname(), [
                'data' => $model::$qrcodeTypeMap,
                'options' => ['placeholder' => '请选择二维码类型'],
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

    <?php // echo $form->field($model, 'expire_seconds')?>

    <?php // echo $form->field($model, 'expired_at')?>

    <?php // echo $form->field($model, 'qrcode_url')?>

    <?php // echo $form->field($model, 'qrcode_image_url')?>

    <?php // echo $form->field($model, 'qrcode_ticket')?>

    <?php // echo $form->field($model, 'status')?>

    <?php // echo $form->field($model, 'created_at')?>

    <?php // echo $form->field($model, 'updated_at')?>

    <?php // echo $form->field($model, 'is_del')?>

    <?php ActiveForm::end(); ?>

</div>
