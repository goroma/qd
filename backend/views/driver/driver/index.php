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
        //'ajaxUpdate' => true,
        'pager' => [
            'firstPageLabel' => 'ι‹',
            'lastPageLabel' => '›ι',
        ],
        'columns' => [
            [
                'class' => 'yii\grid\SerialColumn',
            ],

            'id',
            'qd_name',
            'qd_file_size',
            [
                'attribute' => 'qd_install_type',
                'label' => '安装方式',
                'value' => function ($model) {
                    return $model::$install_type[$model->qd_install_type];
                },
            ],
            'qd_source',
//            'qd_instruction:ntext',
//            'rank',
            //'language',
            //'qd_sha256',
//            'parameter',
//            'note',
            'type',
            'qd_download_url:url',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => Yii::t('app', 'Operation'),
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                            Yii::$app->urlManager->createUrl(['driver/driver/view', 'id' => $model->id]),
                            [
                                'title' => Yii::t('yii', 'View'),
                                'target' => '_blank',
                                'data-pjax' => 0,
                            ]
                        );
                    },
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                            Yii::$app->urlManager->createUrl(['driver/driver/update', 'id' => $model->id, 'edit' => 't']),
                            [
                                'title' => Yii::t('yii', 'Update'),
                                'target' => '_blank',
                                'data-pjax' => 0,
                            ]
                        );
                    },
                    //'delete' => function ($url, $model) {
                        //return Html::a('<span class="glyphicon glyphicon-trash"></span>',
                            //Yii::$app->urlManager->createUrl(['driver/driver/delete', 'id' => $model->id]),
                            //[
                                //'title' => Yii::t('yii', 'Delete'),
                                //'aria-label' => Yii::t('yii', 'Delete'),
                                //'data-confirm' => '您确定要删除此项吗？',
                                //'data-method' => 'post'
                            //]
                        //);
                    //}
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
            'after' => Html::a('<i class="glyphicon glyphicon-repeat"></i> '.Yii::t('app', 'Reset List'), ['index'], ['class' => 'btn btn-info']),
            'showFooter' => false
        ],
    ]); Pjax::end(); ?>

</div>
