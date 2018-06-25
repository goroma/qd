<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\driver\InfSearch $searchModel
 */

$this->title = Yii::t('app', 'Inf');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inf-index">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="glyphicon glyphicon-search"></i> <?= Yii::t('app', 'Inf').Yii::t('app', 'Query') ?></h3>
        </div>
        <div class="panel-body">
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
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
                'attribute' => 'driver_id',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span> '.$model->driver_id,
                        Yii::$app->urlManager->createUrl(['driver/driver/view', 'id' => $model->driver_id]),
                        [
                            'title' => '查看包详情',
                            'data-pjax' => 0,
                        ]
                    );
                },
            ],
            [
                'attribute' => 'driver_id',
                'label' => '包名称',
                'value' => function ($model) {
                    return $model->driver->qd_name;
                },
            ],
            'inf_name',
            'class',
            'driver_ver',
            'driver_pubtime',
            'driver_original_pubtime',
//            ['attribute' => 'driver_pubtime','format' => ['date',(isset(Yii::$app->modules['datecontrol']['displaySettings']['date'])) ? Yii::$app->modules['datecontrol']['displaySettings']['date'] : 'd-m-Y']],
//            'driver_provider',
//            'inf_name',
//            'inf_sha256',
//            ['attribute' => 'created_at','format' => ['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']],
//            ['attribute' => 'updated_at','format' => ['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']],

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('app', 'Operation'),
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                            Yii::$app->urlManager->createUrl(['driver/inf/view', 'id' => $model->id]),
                            [
                                'title' => Yii::t('yii', 'View'),
                                'target' => '_blank',
                                'data-pjax' => 0,
                            ]
                        );
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                            Yii::$app->urlManager->createUrl(['driver/inf/update', 'id' => $model->id, 'edit' => 't']),
                            [
                                'title' => Yii::t('yii', 'Update'),
                                'target' => '_blank',
                                'data-pjax' => 0,
                            ]
                        );
                    }
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
            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> '.Yii::t('app', 'Reset List'), ['index'], ['class' => 'btn btn-info']),
            'showFooter' => false
        ],
    ]); Pjax::end(); ?>

</div>
