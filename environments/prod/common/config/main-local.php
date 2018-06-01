<?php

return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=choristes',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'tablePrefix' => 'cs_',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',

            // 这句一定有，false发送邮件，true只是生成邮件在runtime文件夹下，不发邮件
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',

                // 每种邮箱的host配置不一样
                'host' => 'smtp.163.com',
                'username' => 'example@domain.com',
                'password' => 'xxxxxxxx',
                'port' => '25',
                'encryption' => 'tls',
            ],

            // 这里的配置要和上面一致
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from' => ['example@domain.com' => 'admin'],
            ],
        ],
        'UniqueCode' => [
            'class' => 'common\components\UniqueCode',
        ],
        'PregMatch' => [
            'class' => 'common\components\PregMatch',
        ],
        'ReceiveApiData' => [
            'class' => 'common\components\ReceiveApiData',
        ],
    ],
];
