<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var backend\models\driver\Inf $model
 */

$this->title = Yii::t('app', 'Create').'Inf';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Infs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inf-create">
    <div class="page-header">
        <h4><?= Html::encode($this->title) ?></h4>
    </div>
    <?= $this->render('_form', [
        'model' => $model,
        'drivers' => $drivers,
    ]) ?>

</div>
