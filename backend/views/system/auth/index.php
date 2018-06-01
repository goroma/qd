<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/*
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var core\models\auth\AuthSearch $searchModel
 */

$this->title = Yii::t('app', 'Auths');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-index">
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
//         'filterModel' => $searchModel,
        'toolbar' => [
            'content' => Html::a('<i class="glyphicon glyphicon-plus"></i>', [
                'create',
            ], [
                'class' => 'btn btn-default',
                'title' => Yii::t('app', '添加授权项'),
            ]),
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
//             'type',
            'description:ntext',
//             'rule_name',
//             'data:ntext',
//            'created_at',
//            'updated_at',

            [
                'header' => Yii::t('app', 'Operation'),
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'floatHeader' => true,

        'panel' => [
            'heading' => '<h3 class="panel-title"><i class="glyphicon glyphicon-th-list"></i> '.Html::encode($this->title).' </h3>',
            'type' => 'info',
            'after' => false,
            'before' => '',
            'showFooter' => false,
        ],
    ]); Pjax::end(); ?>

</div>
