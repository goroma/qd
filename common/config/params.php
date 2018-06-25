<?php

return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 600,
    'qiniu' => [
        'accessKey' => 'ta_62nFyHa7yiZUNFzDK8_Ez26jYp3dPqsZkNfrP',
        'secretKey' => 'HKTWfNT80yHVJMuoU52fFg_iEmInUfel7DCKy25S',
        'image_domain' => 'http://image.blianb.com/',
    ],
    'WeChatOption' => [
        'debug' => true,
        //'app_id' => 'wx4c64ac5bf3624576',
        //'secret' => '583a587b38f34147027b3ff742ffedc5',
        //'token'  => 'ushipshop123',
        // 可选 zXgRMbzNqzxDgg1PlhSQOHQrBGHJLHlvkuwYbu5lBWV
        // 'aes_key' => null,
        'log' => [
            'level' => 'debug',
            'file' => '/tmp/easywechat.log',
        ],
    ],
    'WeChatOption1' => [
        'debug' => true,
        //'app_id' => 'wx823f4fd85691a862',
        //'secret' => 'df704e39b113abb37e8fc6fcf78b4154',
        //'token'  => 'ushipshop123',
        // 可选 zXgRMbzNqzxDgg1PlhSQOHQrBGHJLHlvkuwYbu5lBWV
        // 'aes_key' => null,
        'log' => [
            'level' => 'debug',
            'file' => '/tmp/easywechat.log',
        ],
    ],

    // 立方棱镜
    'WeChatOption2' => [
        'debug' => true,
        'app_id' => 'wx773ad00cb3d478f1',
        'secret' => '484fa846c6d30979fee5f0c5cf409247',
        'token' => 'sting_bobo',
        // 'aes_key' => null,
        'log' => [
            'level' => 'debug',
            'file' => '/log/wechat/easywechat'.date('Ymd').'_.log',
        ],
    ],
    'wechatPay' => [
        'app_id' => 'wx84c5058839c79d01',
        'secret' => '1fba6f67f1a617af7093636b26ef6e6d',
        'token' => 'sndsKJ20170223',
        'merchant_id' => '1338862501',
        'md5_key' => 'f68f1ca6f799bec95ecb4face55b070b',
        'key_path' => realpath(__DIR__.'/wechatpay/'),
    ],
    'aliPay' => [
        'app_id' => '2017020905586730',
        'pid' => '2088521507661412',
        'key_path' => realpath(__DIR__.'/alipay/'),
    ],

    // 萤石摄像头接口配置
    'camera' => [
        'appKey' => 'b84b4af9a91d406a8250bb747fd456b1',
        'appSecret' => 'd2fe414f83361f0e042457be4f99ce8b',
    ],

    // 短信发送配置
    'sms' => [
        'uid' => 'huidian',
        'pwd' => 'tz123456',
        'apikey' => '369b3f947e6662c64e047ecf36542689',
    ],
];
