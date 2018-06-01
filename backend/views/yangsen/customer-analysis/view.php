<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/*
 * @var yii\web\View $this
 * @var backend\models\yangsen\CustomerAnalysis $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Customer').Yii::t('app', 'Analysis'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-analysis-view">

    <?= DetailView::widget([
        'model' => $model,
        'condensed' => false,
        'hover' => true,
        'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
        'buttons1' => Html::a(
            '<span class="glyphicon glyphicon-backward"></span>',
            Yii::$app->urlManager->createUrl(['yangsen/customer-analysis/index']
        ), ['title' => Yii::t('app', 'GoBack')]).
        ' {delete}',
        'panel' => [
            'heading' => $this->title,
            'type' => DetailView::TYPE_INFO,
        ],
        'attributes' => [
            'id',
            'name',
            'age',
            [
                'attribute' => 'gender',
                'value' => $model::$genderMap[$model->gender],
            ],
            'height',
            'weigth',
            'occupation',
            [
                'attribute' => 'customer_type',
                'value' => $model::$types[$model->customer_type],
            ],
            [
                'attribute' => 'target',
                'value' => $model::$targets[$model->target],
            ],
            [
                'attribute' => 'disease',
                'value' => $model::$yesorno[$model->disease],
            ],
            'disease_desc',
            [
                'attribute' => 'physical_state',
                'value' => $model::$states[$model->physical_state],
            ],
            [
                'attribute' => 'purchasing_power',
                'value' => $model::$levels[$model->purchasing_power],
            ],
            'remark',
            'consulting_time',
            'consulting_number',
            'created_at',
            'updated_at',
        ],
        'deleteOptions' => [
            'url' => ['delete', 'id' => $model->id],
        ],
        'enableEditMode' => true,
    ]) ?>

</div>
