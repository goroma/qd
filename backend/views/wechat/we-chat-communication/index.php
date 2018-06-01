<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/*
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\wechat\WeChatCommunicationSearch $searchModel
 */

$this->title = Yii::t('app', 'We Chat Communications');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="we-chat-communication-index">
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
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'company_id',
            //'wechat_account_id',
            [
                'attribute' => 'nickname',
                'value' => function ($model) {
                    return $model->weChatUser ? $model->weChatUser->nickname : '';
                },
            ],
            'communication_openid',
            'communication_staff_id',
//            'communication_is_top',
//            'communication_content_type',
//            'communication_operation_status',
//            'is_softdel',
//            ['attribute'=>'created_at','format'=>['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']],

            [
                'header' => Yii::t('app', 'Operation'),
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-pencil"></span>',
                            Yii::$app->urlManager->createUrl(['wechat/communication/update', 'id' => $model->id, 'edit' => 't']),
                            [
                                'title' => Yii::t('app', 'Update'),
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
            'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']),                                                                                                                                                          'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter' => false,
        ],
    ]); Pjax::end(); ?>

</div>
