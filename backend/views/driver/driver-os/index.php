<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\driver\DriverOsSearch $searchModel
 */

$this->title = Yii::t('app', 'Driver Os');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="driver-os-index">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="glyphicon glyphicon-search"></i> <?= Yii::t('app', 'Driver Os').Yii::t('app', 'Query') ?></h3>
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
            'qd_os',
            'qd_pf',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('app', 'Operation'),
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                            Yii::$app->urlManager->createUrl(['driver/driver-os/update', 'id' => $model->id, 'edit' => 't']),
                            ['title' => Yii::t('yii', 'Update')]
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
