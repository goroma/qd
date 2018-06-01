<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;

/*
 * @var yii\web\View $this
 * @var backend\models\yangsen\CustomerAnalysisSearch $model
 * @var yii\widgets\ActiveForm $form
 */
?>

<div class="customer-analysis-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="row">
        <div class="col-sm-2">
            <?= $form->field($model, 'name') ?>
        </div>

        <div class="col-sm-3">
            <?= $form->field($model, 'consulting_start')->widget(DateControl::classname(), [
                'type' => DateControl::FORMAT_DATE,
                'ajaxConversion' => false,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'autoclose' => true,
                        'todayHighlight' => true,
                    ],
                ],
            ]);
            ?>
        </div>
        <div class="col-sm-3">
            <?= $form->field($model, 'consulting_end')->widget(DateControl::classname(), [
                'type' => DateControl::FORMAT_DATE,
                'ajaxConversion' => false,
                'widgetOptions' => [
                    'pluginOptions' => [
                        'autoclose' => true,
                        'todayHighlight' => true,
                    ],
                ],
            ]);
            ?>
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
