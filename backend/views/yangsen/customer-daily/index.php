<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/*
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\yangsen\CustomerDailySearch $searchModel
 */

$this->title = Yii::t('app', 'Customer').Yii::t('app', 'Daily');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-daily-index">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="glyphicon glyphicon-search"></i> <?= Yii::t('app', 'Customer').Yii::t('app', 'Query') ?></h3>
        </div>
        <div class="panel-body">
            <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
    </div>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        'pager' => [
            'firstPageLabel' => 'ι‹',
            'lastPageLabel' => '›ι',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'customer.name',
            'used_at',
            [
                'attribute' => 'is_menstruation',
                'value' => function ($model) {
                    return $model::$yesorno[$model->is_menstruation];
                },
            ],
            [
                'attribute' => 'is_bigu',
                'value' => function ($model) {
                    return $model::$yesorno[$model->is_bigu];
                },
            ],
            [
                'attribute' => 'is_stagnation',
                'value' => function ($model) {
                    return $model::$yesorno[$model->is_stagnation];
                },
            ],
            'morning_weight',
            'night_weight',
            'weight_diff',
            'weight_loss',
//            'breakfast',
//            'lunch',
//            'afternoon_tea',
//            'dinner',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('app', 'Operation'),
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                            Yii::$app->urlManager->createUrl(['yangsen/customer-daily/update', 'id' => $model->id, 'edit' => 't']),
                            ['title' => Yii::t('yii', 'Update')]
                        );
                    },
                ],
            ],
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'floatHeader' => true,

        'panel' => [
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type' => 'info',
            'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('app', 'Add'), ['create'], ['class' => 'btn btn-success']),
            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> 恢复列表', ['index'], ['class' => 'btn btn-info']),
            'showFooter' => false,
        ],
    ]); Pjax::end(); ?>

</div>
