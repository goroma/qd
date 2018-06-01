<?php

use yii\helpers\Html;

/*
 * @var yii\web\View $this
 * @var backend\models\yangsen\CustomerAnalysis $model
 */
$this->title = Yii::t('app', 'Create').Yii::t('app', 'Customer').Yii::t('app', 'Analysis');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Customer').Yii::t('app', 'Analysis'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-analysis-create">
    <div class="page-header">
        <h3><?= Html::encode($this->title) ?></h3>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
