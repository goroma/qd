<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\datecontrol\DateControl;

/*
 * @var yii\web\View $this
 * @var backend\models\wechat\WeChatMenu $model
 */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'We Chat Menus'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="we-chat-menu-view">
    <div class="page-header">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>


    <?= DetailView::widget([
        'model' => $model,
        'condensed' => false,
        'hover' => true,
        'mode' => Yii::$app->request->get('edit') == 't' ? DetailView::MODE_EDIT : DetailView::MODE_VIEW,
        'panel' => [
            'heading' => $this->title,
            'type' => DetailView::TYPE_INFO,
        ],
        'attributes' => [
            'id',
            'company_id',
            'wechat_account_id',
            'menu_pid',
            'menu_name',
            'menu_type',
            'key',
            'url:ntext',
            'media_id',
            'status',
            [
                'attribute' => 'created_at',
                'format' => [
                    'datetime', (isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime']))
                        ? Yii::$app->modules['datecontrol']['displaySettings']['datetime']
                        : 'd-m-Y H:i:s A',
                ],
                'type' => DetailView::INPUT_WIDGET,
                'widgetOptions' => [
                    'class' => DateControl::classname(),
                    'type' => DateControl::FORMAT_DATETIME,
                ],
            ],
            [
                'attribute' => 'updated_at',
                'format' => [
                    'datetime', (isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime']))
                        ? Yii::$app->modules['datecontrol']['displaySettings']['datetime']
                        : 'd-m-Y H:i:s A',
                ],
                'type' => DetailView::INPUT_WIDGET,
                'widgetOptions' => [
                    'class' => DateControl::classname(),
                    'type' => DateControl::FORMAT_DATETIME,
                ],
            ],
            'is_del',
        ],
        'deleteOptions' => [
            'url' => ['delete', 'id' => $model->id],
        ],
        'enableEditMode' => true,
    ]) ?>

</div>
