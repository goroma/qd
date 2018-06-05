<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\driver\InfHid $model
 */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Inf Hid',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Inf Hids'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inf-hid-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
