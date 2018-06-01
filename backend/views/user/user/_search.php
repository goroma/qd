<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

/*
 * @var yii\web\View $this
 * @var backend\models\user\UserSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">

        <div class="col-sm-2">
            <?= $form->field($model, 'mobile') ?>
        </div>

        <div class="col-sm-2">
            <?php echo $form->field($model, 'role')->widget(Select2::classname(), [
                'data' => $model::$roleMap,
                'options' => ['placeholder' => '请选择角色'],
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
    <?php // $form->field($model, 'id')?>

    <?php // $form->field($model, 'company_id')?>

    <?php // $form->field($model, 'name')?>

    <?php // $form->field($model, 'username')?>

    <?php // $form->field($model, 'auth_key')?>

    <?php // echo $form->field($model, 'password_hash')?>

    <?php // echo $form->field($model, 'password_reset_token')?>

    <?php // echo $form->field($model, 'email')?>

    <?php // echo $form->field($model, 'mobile')?>

    <?php // echo $form->field($model, 'localimgurl')?>

    <?php // echo $form->field($model, 'classify')?>

    <?php // echo $form->field($model, 'access_token')?>

    <?php // echo $form->field($model, 'role')?>

    <?php // echo $form->field($model, 'status')?>

    <?php // echo $form->field($model, 'created_at')?>

    <?php // echo $form->field($model, 'updated_at')?>

    <?php // echo $form->field($model, 'is_del')?>

    <?php ActiveForm::end(); ?>

</div>
