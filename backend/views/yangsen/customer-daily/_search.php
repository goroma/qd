<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/*
 * @var yii\web\View $this
 * @var backend\models\yangsen\CustomerDailySearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="customer-daily-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-sm-2">
            <?= $form->field($model, 'customer_name') ?>
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

    <?php ActiveForm::end(); ?>

</div>
