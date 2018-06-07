<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\driver\Inf $model
 */

$this->title = Yii::t('app', 'Update') . 'Inf: ' . $model->inf_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Infs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->inf_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="inf-update">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
        'drivers' => $drivers,
    ]) ?>

</div>
