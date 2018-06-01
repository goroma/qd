<?php

$params = array_merge(
    require(__DIR__.'/../../common/config/params.php'),
    require(__DIR__.'/../../common/config/params-local.php'),
    require(__DIR__.'/params.php'),
    require(__DIR__.'/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'common' => [
            'basePath' => '@app/common',
            'class' => 'api\common\Module',
        ],
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module',
        ],
        'v2' => [
            'basePath' => '@app/modules/v2',
            'class' => 'api\modules\v2\Module',
        ],
    ],
    'components' => [
        'monolog' => [
            'class' => '\Mero\Monolog\MonologComponent',
            'channels' => [
                'main' => [
                    'handler' => [
                        new \Monolog\Handler\StreamHandler(
                            __DIR__.'/../runtime/logs/system.log',
                            \Monolog\Logger::DEBUG
                        ),
                    ],
                    'processor' => [],
                ],
                'api' => [
                    'handler' => [
                        [
                            'type' => 'stream',
                            'path' => '@app/runtime/logs/api_'.date('Y-m-d').'.log',
                            'level' => 'debug',
                        ],
                    ],
                    'processor' => [],
                ],
            ],
        ],

        // 启用 JSON 输入
        'request' => [
            'class' => '\yii\web\Request',
            'enableCookieValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],

        'response' => [
            'class' => 'yii\web\Response',
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                if ($response->data !== null && !is_string($response->data) && 200 != $response->statusCode) {
                    $response->data = [
                        'code' => $response->statusCode,
                        'message' => $response->data['message'],
                    ];
                    $response->statusCode = 200;
                }
            },

            // 记录日志
            'on afterSend' => function ($event) {
                $response = $event->sender;
                if (!is_string($response->data)) {
                    $logger = Yii::$app->monolog->getLogger('api');
                    $logger->log('info', 'Return: ', $response->data);
                }
            },
        ],

        // 授权验证
        'user' => [
            'identityClass' => 'common\models\User',
            'enableSession' => false,
            'enableAutoLogin' => true,
            'loginUrl' => null,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    //'levels' => ['info', 'error', 'warning'],
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                'GET send_email' => 'common/user/send-password-reset-token-mail',
                'POST v1/login' => 'common/user/login',
                'POST v1/register' => 'common/user/register',
                'GET v1/child_qrcode/<id:\d+>' => 'v1/child/child-qrcode',
                'GET v1/camera_access_token' => 'v1/camera/access-token',
                'PUT v1/bind_camera' => 'v1/camera/bind-camera',
                'GET v1/camera_pic/<id:\d+>' => 'v1/camera/device-capture',
                'GET v1/camera_address/<id:\d+>' => 'v1/camera/camera-address',
                //'POST v1/send_message' => 'common/send-message/send-verify-code',
                'GET v1/teacher/<phone:\w+>' => 'v1/teacher/check-teacher',
                'GET v1/homepage' => 'v1/home-page/get-config',
                [
                    'class' => 'yii\rest\UrlRule',
                    // 类似这样
                    //[
                        //'PUT,PATCH users/<id>' => 'user/update',
                        //'DELETE users/<id>' => 'user/delete',
                        //'GET,HEAD users/<id>' => 'user/view',
                        //'POST users' => 'user/create',
                        //'GET,HEAD users' => 'user/index',
                        //'users/<id>' => 'user/options',
                        //'users' => 'user/options',
                    //]

                    // 访问时使用复数
                    'controller' => [
                        'v1/country',
                        'v1/child',
                        'v1/child-transfer',
                        'v1/nursery',
                        'v1/teacher',
                        'v1/teacher-comment',
                        'v1/notice',
                        'v1/notice-record',
                        'v1/cookbook',
                        'v1/camera',
                        'v1/address',
                        'v1/parent-comment',
                    ],
                    'extraPatterns' => [
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\w+>',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'v2/we-chat-request',
                        'v2/we-chat-pay-notify',
                        'v2/payment-notify',
                        'v2/country',
                        'v2/driver',
                        'v2/vehicle',
                        'v2/shop',
                        'v2/pda',
                        'v2/search',
                        'v2/hisstatus',
                    ],
                    'extraPatterns' => [
                        'GET search' => 'search',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\w+>',
                    ],
                ],
            ],
        ],
        'ApiCommon' => [
            'class' => 'api\components\ApiCommon',
        ],
        //'errorHandler' => [
            //'errorAction' => 'common/user/error',
        //],
    ],
    'params' => $params,
];
