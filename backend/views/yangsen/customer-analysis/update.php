<?php

use yii\helpers\Html;

/*
 * @var yii\web\View $this
 * @var backend\models\yangsen\CustomerAnalysis $model
 */

$this->title = Yii::t('app', 'Update').Yii::t('app', 'Customer').Yii::t('app', 'Analysis').': '.$model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Customer').Yii::t('app', 'Analysis'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="customer-analysis-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
