<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\driver\Driver $model
 */

$this->title = Yii::t('app', 'Update') . Yii::t('app', 'Driver') . ': ' . $model->qd_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Driver'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->qd_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="driver-update">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
