<?php

use yii\helpers\Html;

/*
 * @var yii\web\View $this
 * @var backend\models\yangsen\CustomerDaily $model
 */

$this->title = Yii::t('app', 'Create').Yii::t('app', 'Customer').Yii::t('app', 'Daily');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Customer').Yii::t('app', 'Daily'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-daily-create">
    <div class="page-header">
        <h3><?= Html::encode($this->title) ?></h3>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
        'customers' => $customers,
    ]) ?>

</div>
