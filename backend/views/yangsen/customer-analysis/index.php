<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/*
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\yangsen\CustomerAnalysisSearch $searchModel
 */

$this->title = Yii::t('app', 'Customer').Yii::t('app', 'Analysis');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-analysis-index">
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
            [
                'attribute' => 'name',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->name,
                        Yii::$app->urlManager->createUrl(['yangsen/customer-daily/create', 'customer_id' => $model->id]),
                        [
                            'title' => '创建客户日常',
                            'data-pjax' => 0,
                        ]
                    );
                },
            ],
            'age',
            [
                'attribute' => 'gender',
                'value' => function ($model) {
                    return $model::$genderMap[$model->gender];
                },
            ],
            [
                'attribute' => 'customer_type',
                'value' => function ($model) {
                    return $model::$types[$model->customer_type];
                },
            ],
            'height',
            'weigth',
            [
                'attribute' => 'consulting_time',
                'label' => '咨询日期',
                'value' => function ($model) {
                    if ($model->consulting_time) {
                        return date('Y-m-d', strtotime($model->consulting_time));
                    } else {
                        return null;
                    }
                },
            ],
            'consulting_number',
//            'customer_type',
//            'target',
//            'disease',
//            'disease_desc',
//            'physical_state',
//            'purchasing_power',
//            'remark',
//            ['attribute' => 'created_at','format' => ['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']],
//            ['attribute' => 'updated_at','format' => ['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']],
//            'is_del',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {daily}',
                'header' => Yii::t('app', 'Operation'),
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                            Yii::$app->urlManager->createUrl(['yangsen/customer-analysis/update', 'id' => $model->id, 'edit' => 't']),
                            ['title' => Yii::t('yii', 'Update')]
                        );
                    },
                    'daily' => function ($url, $model) {
                        return Html::a('&nbsp;<span class="glyphicon glyphicon-calendar"></span>',
                            Yii::$app->urlManager->createUrl(['yangsen/customer-daily/index', 'CustomerDailySearch[customer_name]' => $model->name, 'edit' => 't']),
                            [
                                'title' => '查看客户日常',
                                'data-pjax' => 0,
                            ]
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
