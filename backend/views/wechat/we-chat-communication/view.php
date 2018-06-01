<?php

use yii\helpers\Html;
use kartik\dialog\Dialog;

// widget with default options
echo Dialog::widget();

/*
 * @var yii\web\View $this
 * @var backend\models\wechat\WeChatCommunication $model
 */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'We Chat Communications'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?=Html::cssFile('@web/css/qrcodeImage.css')?>
<div class="col-md-9">
          <!-- DIRECT CHAT SUCCESS -->
          <div class="box box-success direct-chat direct-chat-success">
            <div class="box-header with-border">
              <h3 class="box-title">微信聊天</h3>
              <input type="hidden" id="openId" value="<?= $model->weChatUser->openid; ?>" />
              <input type="hidden" id="nickname" value="<?= $model->weChatUser->nickname; ?>" />

              <div class="box-tools pull-right">
                <span data-toggle="tooltip" title="3 New Messages" class="badge bg-green">3</span>
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="" data-widget="chat-pane-toggle" data-original-title="Contacts">
                  <i class="fa fa-comments"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <!-- Conversations are loaded here -->
                <div class="direct-chat-messages" style="min-height:350px">
                    <?php foreach (array_reverse($model->weChatUser->weChatCommunications) as $chat) {
    echo '<input type="hidden" class="chat-id" value="'.$chat->id.'">';
    if (0 == $chat->communication_direction) {
        ?>
                    <!-- Message. Default to the left -->
                    <div class="direct-chat-msg wechat-chat-msg">
                        <!-- /.direct-chat-info -->
                        <div class="direct-chat-info clearfix">
                            <span class="direct-chat-name pull-left"><?= $chat->weChatUser->nickname; ?></span>
                            <span class="direct-chat-timestamp pull-left"><?= $chat->created_at; ?></span>
                        </div>
                        <img class="direct-chat-img" src="<?= $chat->weChatUser->headimgurl; ?>" alt="<?= $chat->weChatUser->nickname; ?>"><!-- /.direct-chat-img -->
                        <div class="direct-chat-text" style="width:50%;min-height:60px">
                            <?php
                                if (0 == $chat->communication_content_type) {
                                    echo $chat->weChatCommunicationText->communication_text_content;
                                } elseif (1 == $chat->communication_content_type) {
                                    echo '<img class="direct-chat-img" src="'.$chat->weChatCommunicationImage->communication_image_picurl.'" alt="Message User Image">';
                                } elseif (2 == $chat->communication_content_type) {
                                    echo '语音文字：'.$chat->weChatCommunicationVoice->communication_voice_recognition;
                                    echo '<audio controls> <source src="'.$chat->weChatCommunicationVoice->communication_voice_url.'" type="audio/mpeg"> </audio>';
                                } ?>
                        </div>
                      <!-- /.direct-chat-text -->
                    </div>
                    <!-- /.ect-chat-msg -->
                    <?php
    } elseif (1 == $chat->communication_direction) {
        ?>
                    <!-- Message to the right -->
                    <div class="direct-chat-msg system-chat-msg right">
                        <div class="direct-chat-info clearfix">
                            <span class="direct-chat-name pull-right"><?= $chat->systemUser->username; ?></span>
                            <span class="direct-chat-timestamp pull-right"><?= $chat->created_at; ?></span>
                        </div>
                        <!-- /.direct-chat-info -->
                        <img class="direct-chat-img" src="<?= $chat->systemUser->localimgurl; ?>" alt="Message User Image"><!-- /.direct-chat-img -->
                        <div class="direct-chat-text pull-right" style="width:50%;min-height:60px">
                        <?php
                            if (0 == $chat->communication_content_type) {
                                echo $chat->weChatCommunicationText->communication_text_content;
                            } elseif (1 == $chat->communication_content_type) {
                                echo '<img class="direct-chat-img" src="'.$chat->weChatCommunicationImage->communication_image_picurl.'" alt="Message User Image">';
                            } elseif (2 == $chat->communication_content_type) {
                                echo '语音文字：'.$chat->weChatCommunicationVoice->communication_voice_recognition;
                                echo '<audio controls> <source src="'.$chat->weChatCommunicationVoice->communication_voice_url.'" type="audio/mpeg"> </audio>';
                            } ?>
                        </div>
                      <!-- /.direct-chat-text -->
                    </div>
                    <!-- /.direct-chat-msg -->
                <?php
    }
}
                ?>
                <!--/.direct-chat-messages-->
                </div>

                <!-- Contacts are loaded here -->
                <div class="direct-chat-contacts">
                    <ul class="contacts-list">
                        <li>
                            <a href="#">
                                <img class="contacts-list-img" src="../dist/img/user1-128x128.jpg">

                                <div class="contacts-list-info">
                                    <span class="contacts-list-name">
                                        Count Dracula
                                        <small class="contacts-list-date pull-right">2/28/2015</small>
                                    </span>
                                    <span class="contacts-list-msg">How have you been? I was...</span>
                                </div>
                            <!-- /.contacts-list-info -->
                            </a>
                        </li>
                    <!-- End Contact Item -->
                    </ul>
                <!-- /.contatcts-list -->
                </div>
              <!-- /.direct-chat-pane -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <form action="#" method="post">
                <div class="input-group">
                  <input type="text" id="send-message" name="message" placeholder="请输入内容 ..." class="form-control">
                      <span class="input-group-btn">
                        <button id="send-message-button" type="button" class="btn btn-success btn-flat">Send</button>
                      </span>
                </div>
              </form>
            </div>
            <!-- /.box-footer-->
          </div>
          <!--/.direct-chat -->
        </div>

        <div class="bg_img">
            <img src="">
        </div>
<?php

$js = <<< JS
$('.direct-chat-messages')[0].scrollTop = $('.direct-chat-messages')[0].scrollHeight;

$("#send-message-button").on("click", function() {
    var message = $("#send-message").val();
    if (message == '' || message == undefined) {
        krajeeDialog.alert("消息内容不能为空!");

        return false;
    }

    sendMessage();
});

$('#send-message').bind('keypress', function(event) {
    if (event.keyCode == "13") {
        event.preventDefault();

        var message = $("#send-message").val();
        if (message == '' || message == undefined) {
            krajeeDialog.alert("消息内容不能为空!");

            return false;
        }

        sendMessage();
    }
});

var sendMessage = function () {
    var url = 'send-message';
    var openId = $("#openId").val();
    var message = $("#send-message").val();
    $("#send-message").val('').focus();
    $.ajax({
        url : url,
        data : {openId : openId, message: message},
        type : 'POST',
        dataType : 'json',
        success : function (msg) {
            console.log(msg);
            if (200 == msg.code) {
                var chat = $(".direct-chat-messages > div").last();

                var system_chat_user = '<div class="direct-chat-info clearfix"> <span class="direct-chat-name pull-right">'+msg.data.userinfo.username+'</span> <span class="direct-chat-timestamp pull-right">'+msg.data.created_at+'</span> </div>';

                var system_chat_img = '<img class="direct-chat-img" src="'+msg.data.userinfo.localimgurl+'" alt="Message User Image">';
                var system_chat_message = '<div class="direct-chat-text pull-right" style="width:50%;min-height:60px">'+message+'</div>';
                chat.after('<div class="direct-chat-msg system-chat-msg right">'+system_chat_user+system_chat_img+system_chat_message+'</div>');

                $('.direct-chat-messages')[0].scrollTop = $('.direct-chat-messages')[0].scrollHeight;
            } else {
                krajeeDialog.alert("oops,发送失败!")
            }
        }
    });
}

$(function() {
    var openId = $("#openId").val();
    var nickname = $("#nickname").val();
    document.cookie = '';
    function wsStart() {
        ws = new WebSocket("ws://shopadmin.blianb.com:8004/userId="+openId);
        ws.onopen = function() {
            console.log('websocket:连接打开');
        };

        ws.onclose = function() {
            console.log('websocket:连接被关闭，尝试重新连接');
            setTimeout(wsStart, 1000);
        };

        ws.onmessage = function(evt) {
            var data = JSON.parse(evt.data);
            console.log(evt);
            console.log(data);

            var chat = $(".direct-chat-messages > div").last();
            if (200 == data.code) {
                var html = '<div class="direct-chat-msg wechat-chat-msg">'+
                    '<div class="direct-chat-info clearfix">'+
                        '<span class="direct-chat-name pull-left">'+nickname+'</span>'+
                        '<span class="direct-chat-timestamp pull-left">'+data.message.CreateTime+'</span>'+
                    '</div>'+
                    '<img class="direct-chat-img" src="'+data.message.user.headimgurl+'" alt="'+nickname+'">'+
                    '<div class="direct-chat-text" style="width:50%;min-height:60px">';

                // 具体内容
                if (0 == data.msgType) {
                    html += data.message.Content;
                } else if (1 == data.msgType) {
                    html += '<img class="direct-chat-img" src="'+data.message.communicationDetail.communication_image_picurl+'" alt="Message User Image">';
                } else if (2 == data.msgType) {
                    html += '语音文字：'+data.message.Recognition+
                    '<audio controls> <source src="'+data.message.communicationDetail.communication_voice_url+'" type="audio/mpeg"> </audio>';
                } else if (3 == data.msgType) {
                } else if (4 == data.msgType) {
                } else if (5 == data.msgType) {
                }

                html += '</div></div>';

                chat.after(html);

                $('.direct-chat-messages')[0].scrollTop = $('.direct-chat-messages')[0].scrollHeight;
            }
        };
    }

    wsStart();
});

// 下拉加载功能
var flag = true;
$('.direct-chat-messages').scroll(function() {
    var openId = $("#openId").val();
    var chatId = $(".chat-id").first().val();
    console.log(chatId);
    if (0 == $('.direct-chat-messages')[0].scrollTop && flag) {
        flag = false;
        var url = 'get-history-messages';
        $.ajax({
            url : url,
            data : {openId: openId, id: chatId},
            type : 'POST',
            dataType : 'json',
            success : function (msg) {
                console.log(msg);
                if (200 == msg.code) {
                    flag = true;
                    var len = msg.data.length;
                    for (var i = 0; i < len; i++) {

                        var html = '<input type="hidden" class="chat-id" value="'+msg.data[i].id.communication_id+'">';
                        if (0 == msg.data[i].communication_direction) {
                            html += '<div class="direct-chat-msg wechat-chat-msg">'+
                                '<div class="direct-chat-info clearfix">'+
                                    '<span class="direct-chat-name pull-left">'+msg.data[i].communication_openid.nickname+'</span>'+
                                    '<span class="direct-chat-timestamp pull-left">'+msg.data[i].created_at+'</span>'+
                                '</div>'+
                                '<img class="direct-chat-img" src="'+msg.data[i].communication_openid.headimgurl+'" alt="'+msg.data[i].communication_openid.nickname+'">'+
                                '<div class="direct-chat-text" style="width:50%;min-height:60px">';
                        } else if (1 == msg.data[i].communication_direction) {
                            html += '<div class="direct-chat-msg system-chat-msg right">'+
                                '<div class="direct-chat-info clearfix">'+
                                    '<span class="direct-chat-name pull-right">'+msg.data[i].communication_staff_id.username+'</span>'+
                                    '<span class="direct-chat-timestamp pull-right">'+msg.data[i].created_at+'</span>'+
                                '</div>'+
                                '<img class="direct-chat-img" src="'+msg.data[i].communication_staff_id.localimgurl+'" alt="Message User Image">'+
                                '<div class="direct-chat-text pull-right" style="width:50%;min-height:60px">';
                        }

                        // 具体内容
                        if (0 == msg.data[i].communication_content_type) {
                                html += msg.data[i].id.communication_text_content;
                        } else if (1 == msg.data[i].communication_content_type) {
                                html += '<img class="direct-chat-img" src="'+msg.data[i].id.communication_image_picurl+'" alt="Message User Image">';
                        } else if (2 == msg.data[i].communication_content_type) {
                                html += '语音文字：'+msg.data[i].id.communication_voice_recognition+
                                '<audio controls> <source src="'+msg.data[i].id.communication_voice_url+'" type="audio/mpeg"> </audio>';
                        } else if (3 == msg.data[i].communication_content_type) {
                            console.log(msg.data[i]);
                        } else if (4 == msg.data[i].communication_content_type) {
                            console.log(msg.data[i]);
                        } else if (5 == msg.data[i].communication_content_type) {
                            console.log(msg.data[i]);
                        }

                        html += '</div></div>';
                        $(".direct-chat-messages").prepend(html);
                    }
                    //console.log($('.direct-chat-messages')[0].scrollHeight / 2);
                    //$('.direct-chat-messages')[0].scrollTop = $('.direct-chat-messages')[0].scrollHeight / 2;
                    $('.direct-chat-messages')[0].scrollTop = len * 95;
                } else {
                    flag = false;
                }
            }
        });
    }
});

$('.direct-chat-messages').delegate('.direct-chat-img','click',function() {
    $('.bg_img img').attr('src','');
    var this_url = $(this).attr('src');
    $('.bg_img img').attr('src',this_url);
    $('.bg_img').fadeIn(500,function() {
        var winH = $(window).height();
        var winW = $(window).width();
        var imgH = $('.bg_img img').height();
        var imgW = $('.bg_img img').width();
        if (imgW > winW) {
            $('.bg_img img').css({
                width:winW,
                height:'auto'
            });
        }else if (imgH > winH) {
            $('.bg_img img').css({
                height:winH,
                width:'auto'
            });
        } else {
            $('.bg_img img').css({
                height:'auto',
                width:'auto'
            });
        }
    });
});
$('.bg_img').click(function() {
    $('.bg_img').fadeOut(500);
});

JS;
$this->registerJs($js);
?>
