<?php


/*
 * @var yii\web\View $this
 * @var boss\models\SystemUser $model
 */

$this->title = Yii::t('app', '更新用户资料');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'System Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="system-user-update">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
