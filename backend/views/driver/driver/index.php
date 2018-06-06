<?php

use kartik\grid\GridView;
use kartik\file\FileInput;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\driver\DriverSearch $searchModel
 */

$this->title = Yii::t('app', 'Driver');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="driver-index">
    <div class="panel panel-info">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="glyphicon glyphicon-search"></i> <?= Yii::t('app', 'Driver').Yii::t('app', 'Query') ?></h3>
        </div>
        <div class="panel-body">
            <?php echo $this->render('_search', ['model' => $searchModel]); ?>
        </div>
    </div>

    <div class="panel panel-info">
    <!-- 批量上传 -->
        <div class="row">
            <?php $form = ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data', 'accept-charset' => 'UTF-8'],
                'action' => ['index'],
                'method' => 'post',
            ]);
            ?>
            <div class='col-md-4'>
                <?php
                echo FileInput::widget([
                    'model' => $model,
                    'attribute' => 'driver_file',
                    'options' => ['multiple' => false],
                    'pluginOptions' => [
                        'showPreview' => false,
                        'showCaption' => true,
                        'showRemove' => true,
                        'showUpload' => false
                    ]
                ]);
                ?>
            </div>
            <div class='col-md-2 col-md-offset-0'>
              <?= Html::submitButton(Yii::t('app', '提交'), ['class' => 'btn btn-primary', 'id' => 'testup']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <!-- 批量上传 -->

    <?php Pjax::begin(); echo GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'pager' => [
            'firstPageLabel' => 'ι‹',
            'lastPageLabel' => '›ι',
        ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'qd_name',
            'qd_file_size',
            //'qd_sha256',
            'qd_install_type',
            'qd_source',
//            'qd_download_url:url',
//            'qd_instruction:ntext',
//            'rank',
//            'language',
//            'parameter',
//            'note',
//            'type',
//            ['attribute' => 'created_at','format' => ['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']],
//            ['attribute' => 'updated_at','format' => ['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']],
//            'is_del',

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                            Yii::$app->urlManager->createUrl(['driver/view', 'id' => $model->id, 'edit' => 't']),
                            ['title' => Yii::t('yii', 'Edit'),]
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
            'before' => Html::a('<i class="glyphicon glyphicon-plus"></i> Add', ['create'], ['class' => 'btn btn-success']),
            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset List', ['index'], ['class' => 'btn btn-info']),
            'showFooter' => false
        ],
    ]); Pjax::end(); ?>

</div>
