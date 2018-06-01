<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/*
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\user\UserSearch $searchModel
 */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="glyphicon glyphicon-search"></i> <?= Html::encode($this->title) ?></h3>
        </div>
        <div class="panel-body">
            <?php  echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
    </div>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            //'company_id',
            'name',
            'username',
            //'auth_key',
//            'password_hash',
//            'password_reset_token',
//            'email:email',
//            'mobile',
        [
            'attribute' => 'role',
            'value' => function ($model) {
                return $model::$roleMap[$model->role];
            },
        ],
        [
            'attribute' => 'created_at',
            'label' => '注册时间',
            'value' => function ($model) {
                return $model->created_at;
            },
        ],
//            'localimgurl:url',
//            'classify',
//            'access_token',
//            'role',
//            'status',
//            ['attribute' => 'created_at','format' => ['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']],

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('app', 'Operation'),
                'template' => '{view}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                            Yii::$app->urlManager->createUrl(['user/user/update', 'id' => $model->id, 'edit' => 't']),
                            ['title' => Yii::t('yii', 'Edit')]
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
            'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']),
            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter' => false,
        ],
    ]); Pjax::end(); ?>

</div>
