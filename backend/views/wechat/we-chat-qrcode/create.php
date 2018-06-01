<?php

use yii\helpers\Html;

/*
 * @var yii\web\View $this
 * @var backend\models\wechat\WeChatQrcode $model
 */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'We Chat Qrcode',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'We Chat Qrcodes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="we-chat-qrcode-create">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
