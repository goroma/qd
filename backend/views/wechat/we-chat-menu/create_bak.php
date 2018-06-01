<?php

use yii\helpers\Html;

/*
 * @var yii\web\View $this
 * @var backend\models\wechat\WeChatMenu $model
 */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'We Chat Menu',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'We Chat Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="we-chat-menu-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
