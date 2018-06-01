<?php

use yii\helpers\Html;
use kartik\detail\DetailView;

/*
 * @var yii\web\View $this
 * @var backend\models\user\User $model
 */

$this->title = $model->mobile;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <?= DetailView::widget([
        'model' => $model,
        'condensed' => false,
        'hover' => true,
        'buttons1' => Html::a(
            '<span class="glyphicon glyphicon-backward"></span>',
            Yii::$app->urlManager->createUrl(['user/user/index']
        ), ['title' => Yii::t('app', 'GoBack')]).
        ' {delete}',
        'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
        'panel' => [
            'heading' => $this->title,
            'type' => DetailView::TYPE_INFO,
        ],
        'attributes' => [
            'id',
            //'company_id',
            'name',
            'username',
            //'auth_key',
            //'password_hash',
            //'password_reset_token',
            'email:email',
            'mobile',
            [
                'attribute' => 'localimgurl',
                'format' => 'raw',
                'value' => Html::img($model->localimgurl,
                    [
                        'alt' => '用户头像',
                        'title' => $model->mobile,
                        'class' => 'image',
                        'height' => 150,
                    ]
                ),
            ],
            'classify',
            [
                'attribute' => 'role',
                'value' => $model::$roleMap[$model->role],
            ],
            'status',
            'created_at',
            'updated_at',
            [
                'attribute' => 'is_del',
                'value' => $model::$isDelMap[$model->is_del],
            ],
        ],
        'deleteOptions' => [
            'url' => ['delete', 'id' => $model->id],
        ],
        'enableEditMode' => true,
    ]) ?>

</div>
