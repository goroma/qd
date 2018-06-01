<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/*
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\wechat\WeChatUserSearch $searchModel
 */

$this->title = Yii::t('app', 'We Chat Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="we-chat-user-index">
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
        'pager' => [
            'firstPageLabel' => 'ι‹',
            'lastPageLabel' => '›ι',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            //'company_id',
            //'wechat_account_id',
            'nickname',
            'openid',
            //'unionid',
            //            'groupid',
            'country',
            'province',
            'city',
            [
                'attribute' => 'gender',
                'value' => function ($model) {
                    return $model::$genderMap[$model->gender];
                },
            ],
            'language',
            [
                'attribute' => 'headimgurl',
                'format' => ['image', ['height' => '40', 'alt' => 'image', 'title' => '微信粉丝图像', 'class' => 'image']],
                'value' => function ($model) {
                    if (empty($model->headimgurl)) {
                        return '';
                    } else {
                        return $model->headimgurl;
                    }
                },
            ],
            // 'localimgurl:url',
            [
                'attribute' => 'subscribe',
                'value' => function ($model) {
                    return $model::$subscribeMap[$model->subscribe];
                },
            ],
            'subscribe_time',
            //'unsubscribe_time',
//            ['attribute' => 'unsubscribe_time','format' => ['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']],
//            ['attribute' => 'lastest_communication_time','format' => ['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']],
//            'remark:ntext',
//            ['attribute' => 'created_at','format' => ['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']],
//            'is_del',

            [
                'header' => Yii::t('app', 'Operation'),
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                            Yii::$app->urlManager->createUrl(['we-chat-user/view', 'id' => $model->id, 'edit' => 't']),
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
