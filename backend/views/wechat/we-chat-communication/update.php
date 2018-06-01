<?php

use yii\helpers\Html;

/*
 * @var yii\web\View $this
 * @var backend\models\wechat\WeChatCommunication $model
 */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'We Chat Communication',
]).' '.$model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'We Chat Communications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="we-chat-communication-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
