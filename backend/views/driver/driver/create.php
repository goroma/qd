<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\driver\Driver $model
 */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Driver',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Drivers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="driver-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
