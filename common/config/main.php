<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'zh-CN',
    'timeZone' => 'Asia/Shanghai',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        //'view' => [
            //'theme' => [
                //'pathMap' => [
                    //'@app/views' => '@vendor/dmstr/yii2-adminlte-asset/example-views/yiisoft/yii2-app'
                //],
            //],
        //],
        //'assetManager' => [
            //'bundles' => [
                //'dmstr\web\AdminLteAsset' => [
                    //'skin' => "skin-blue",
                    //'skin' => "skin-black",
                    //'skin' => "skin-red",
                    //'skin' => "skin-yellow",
                    //'skin' => "skin-purple",
                    //'skin' => "skin-green",
                    //'skin' => "skin-blue-light",
                    //'skin' => "skin-black-light",
                    //'skin' => "skin-red-light",
                    //'skin' => "skin-yellow-light",
                    //'skin' => "skin-purple-light",
                    //'skin' => "skin-green-light"
                //],
            //],
        //],
        //'authManager' => [
            //'class' => 'yii\rbac\DbManager',
            //'itemTable' => 'auth_item',
            //'assignmentTable' => 'auth_assignment',
            //'itemChildTable' => 'auth_item_child',
        //],
        // Url映射规则
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            //'enableStrictParsing' => true,
            'rules' => [
                //'<controller:\w+>/<id:\d+>' => '<controller>/view',
                //'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                //'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ],
        ],
        // rbac权限管理
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        // 国际化
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                    'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/error' => 'error.php',
                    ],
                ],
            ],
        ],
        'websocket' => [
            'class' => 'morozovsk\yii2websocket\Connection',
            'servers' => [
                'chat3' => [
                    'class' => 'morozovsk\websocket\examples\chat3\server\Chat3WebsocketDaemonHandler',
                    'pid' => '/tmp/websocket_chat.pid',
                    'websocket' => 'tcp://shopadmin.blianb.com:8004',
                    'localsocket' => 'tcp://shopadmin.blianb.com:8010',
                    //'master' => 'tcp://127.0.0.1:8020',
                    //'eventDriver' => 'event'
                ]
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
        ],
    ],
    'controllerMap' => [
        'websocket' => 'morozovsk\yii2websocket\console\controllers\WebsocketController'
    ],
    'modules' => [
        'datecontrol' =>  [
            'class' => 'kartik\datecontrol\Module',

            // format settings for displaying each date attribute
            'displaySettings' => [
                'date' => 'php:Y-m-d',
                'time' => 'H:i:s',
                'datetime' => 'php:Y-m-d H:i:s',
            ],

            // format settings for saving each date attribute
            'saveSettings' => [
                'date' => 'php:Y-m-d',
                'time' => 'H:i:s',
                'datetime' => 'php:Y-m-d H:i:s',
            ],

            // automatically use kartik\widgets for each of the above formats
            'autoWidget' => true,
        ],

        /**
         * 配置动态grid表格控件
         *  add by zhanghang 2015-09-23
         *
         * yii2-dynagrid模块是一个很好的互补的kartik-v / yii2-grid模块,加强个性化特性。涡轮指控你的网格视图,它为每个用户动态和个性化。它允许用户设置和保存自己的网格配置。这个模块提供的主要功能有:
         * 个性化设置,并保存电网在运行时页面大小。你可以设置最小和最大允许页面大小。
         * 个性化设置,并保存网格数据过滤器在运行时。用户可以定义并保存他/她自己的个性化的网格数据过滤器。
         * 个性化设置,并保存在运行时网格列排序。用户可以定义并保存他/她自己的个性化网格列排序。
         * 通过拖拽个性化网格列显示。重新排序网格列和列设置所需的可见性,并允许用户保存该设置。控制哪些列可以通过预定义的用户重新排序的列设置。预先确定你想要哪一列将总是默认固定到左边或者右边。
         * 网格外观和个性化设置网格的主题。这将提供高级定制的网格布局。它允许用户几乎风格电网无论如何他们想要的,基于你如何定义主题和扩展你的用户。因为扩展使用yii2-grid扩展,它提供了所有的样式选项yii2-grid扩展提供了包括各种网格列的增强,引导板和其他网格样式。这将允许您轻松地为用户设置的主题在许多方面。你有能力设置多个主题模块配置,并允许用户选择其中之一。默认的扩展包括一些预定义的主题开始。
         * 允许你保存动态网格配置特定于每个用户或全球层面。实现了一个 DynaGridStore对象来管理dynagrid个人化操作独立的存储。下列存储选项可用来存储个性化的网格配置:
         * 会话存储(默认)
         * Cookie存储
         * 数据库存储
         * 扩展自动验证基于存储和加载已保存的配置设置。
         *
         * 查看完整的演示效果：http://demos.krajee.com/dynagrid-demo
         * 使用参考：http://demos.krajee.com/dynagrid
         */
        'dynagrid' => [
            'class' => '\kartik\dynagrid\Module',
            // other module settings
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module',
            // other module settings
        ],
    ]
];
