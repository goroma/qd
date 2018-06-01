<?php

use yii\helpers\Html;

/*
 * @var yii\web\View $this
 * @var backend\models\user\User $model
 */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'User',
]).' '.$model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
