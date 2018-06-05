<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\driver\DriverOs $model
 */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Driver Os',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Driver Os'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="driver-os-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
