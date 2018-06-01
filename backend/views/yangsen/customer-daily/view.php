<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/*
 * @var yii\web\View $this
 * @var backend\models\yangsen\CustomerDaily $model
 */

$this->title = $model->customer->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Customer').Yii::t('app', 'Daily'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-daily-view">

    <?= DetailView::widget([
        'model' => $model,
        'condensed' => false,
        'hover' => true,
        'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
        'buttons1' => Html::a(
            '<span class="glyphicon glyphicon-backward"></span>',
            Yii::$app->urlManager->createUrl(['yangsen/customer-daily/index']
        ), ['title' => Yii::t('app', 'GoBack')]).
        ' {delete}',
        'panel' => [
            'heading' => $this->title,
            'type' => DetailView::TYPE_INFO,
        ],
        'attributes' => [
            'id',
            [
                'attribute' => 'customer_name',
                'format' => 'raw',
                'value' => ($customer = $model->customer) !== null ? $customer->name : '<span class="not-set">(未设置客户)</span>',
            ],
            'used_at',
            [
                'attribute' => 'is_menstruation',
                'value' => $model::$yesorno[$model->is_menstruation],
            ],
            [
                'attribute' => 'is_bigu',
                'value' => $model::$yesorno[$model->is_bigu],
            ],
            [
                'attribute' => 'is_stagnation',
                'value' => $model::$yesorno[$model->is_stagnation],
            ],
            'breakfast',
            'lunch',
            'afternoon_tea',
            'dinner',
            'morning_weight',
            'night_weight',
            'weight_diff',
            'weight_loss',
            'created_at',
            'updated_at',
        ],
        'deleteOptions' => [
            'url' => ['delete', 'id' => $model->id],
        ],
        'enableEditMode' => true,
    ]) ?>

</div>
