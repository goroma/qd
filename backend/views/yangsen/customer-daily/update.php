<?php

use yii\helpers\Html;

/**
 * @var yii\web\View
 * @var backend\models\yangsen\CustomerDaily $model
 */
$name = ($customer = $model->customer) ? $customer->name : '没有设置用户名';
$this->title = Yii::t('app', 'Update').Yii::t('app', 'Customer').Yii::t('app', 'Daily').': '.$name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Customer').Yii::t('app', 'Daily'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="customer-daily-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'customers' => $customers,
        'model' => $model,
    ]) ?>

</div>
