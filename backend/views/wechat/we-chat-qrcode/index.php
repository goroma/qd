<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/*
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\wechat\WeChatQrcodeSearch $searchModel
 */

$this->title = Yii::t('app', 'We Chat Qrcodes');
$this->params['breadcrumbs'][] = $this->title;
?>
<?=Html::cssFile('@web/css/qrcodeImage.css')?>

<div class="we-chat-qrcode-index">
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
            //'company_id',
            //'wechat_account_id',
            [
                'attribute' => 'qrcode_type',
                'value' => function ($model) {
                    return $model::$qrcodeTypeMap[$model->qrcode_type];
                },
            ],
            'scene_key',
            'expire_seconds',
            [
                'attribute' => 'expired_at',
                'value' => function ($model) {
                    //return $model::$qrcodeTypeMap[$model->qrcode_type];
                    if (strtotime($model->expired_at) - time() > 0) {
                        return $model->expired_at;
                    } else {
                        return $model->expired_at.' (已失效)';
                    }
                },
            ],
//            'qrcode_url:url',
            [
                'attribute' => 'qrcode_image_url',
                'format' => ['image', ['height' => '40', 'alt' => 'image', 'title' => '二维码图片', 'class' => 'qrcode-image']],
                'value' => function ($model) {
                    return $model->qrcode_image_url;
                },
            ],
//            'qrcode_ticket',
//            'status',
//            ['attribute' => 'created_at','format' => ['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']],
//            ['attribute' => 'updated_at','format' => ['datetime',(isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A']],
//            'is_del',

            [
                'header' => Yii::t('app', 'Operation'),
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'update' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',
                            Yii::$app->urlManager->createUrl(['we-chat-qrcode/view', 'id' => $model->id, 'edit' => 't']),
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

<div class="bg_img">
    <img src="">
</div>
<?php

$js = <<< JS
      $('.qrcode-image').click(function() {
        $('.bg_img img').attr('src','');
        var this_url = $(this).attr('src');
        $('.bg_img img').attr('src',this_url);
        $('.bg_img').fadeIn(500,function() {
            var winH = $(window).height();
            var winW = $(window).width();
            var imgH = $('.bg_img img').height();
            var imgW = $('.bg_img img').width();
            if(imgW > winW){
                $('.bg_img img').css({
                    width:winW,
                    height:'auto'
                })
            }else if(imgH > winH){
                $('.bg_img img').css({
                    height:winH,
                    width:'auto'
                })
            }else{
                $('.bg_img img').css({
                    height:'auto',
                    width:'auto'
                })
            }
        });
    });
    $('.bg_img').click(function() {
        $('.bg_img').fadeOut(500);
    });

JS;

$this->registerJs($js);
?>
