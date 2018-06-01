<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

/*
 * @var yii\web\View $this
 * @var backend\models\wechat\WeChatMenuSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="we-chat-menu-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">

        <div class="col-sm-2">
            <?= $form->field($model, 'menu_name') ?>
        </div>

        <div class="col-sm-2">
            <?php echo $form->field($model, 'menu_type')->label('菜单类型')->widget(Select2::classname(), [
                'data' => $model::$menuTypeMap,
                'options' => ['placeholder' => '请选择菜单类型'],
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

    <?php // echo $form->field($model, 'menu_type')?>

    <?php // echo $form->field($model, 'key')?>

    <?php // echo $form->field($model, 'url')?>

    <?php // echo $form->field($model, 'media_id')?>

    <?php // echo $form->field($model, 'status')?>

    <?php // echo $form->field($model, 'created_at')?>

    <?php // echo $form->field($model, 'updated_at')?>

    <?php // echo $form->field($model, 'is_del')?>

    <?php ActiveForm::end(); ?>

</div>
