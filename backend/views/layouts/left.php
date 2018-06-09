<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= Yii::t('app', '{name}', ['name' => Yii::$app->user->identity->username]) ?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

<?php
use dmstr\widgets\Menu;
use backend\components\RbacHelper;

echo Menu::widget(
    [
        'options' => ['class' => 'sidebar-menu', 'data-widget' => 'tree'],
        'items' => RbacHelper::menu([
            ['label' => '系统菜单', 'url' => ['#'], 'options' => ['class' => 'header']],
            [
                'label' => '驱动管理',
                'url' => [
                    '#',
                ],
                'icon' => 'user',
                'can' => 'sidebar_driver_managemet',
                'options' => [
                    'class' => 'treeview rootTree',
                ],
                'items' => [
                    [
                        'label' => '包管理',
                        'can' => 'sidebar_driver',
                        'url' => [
                            'driver/driver/index',
                        ],
                        'icon' => 'angle-right',
                    ],
                    //[
                        //'label' => '包系统管理',
                        //'can' => 'sidebar_driver_os',
                        //'url' => [
                            //'driver/driver-os/index',
                        //],
                        //'icon' => 'angle-right',
                    //],
                    [
                        'label' => 'inf管理',
                        'can' => 'sidebar_inf',
                        'url' => [
                            'driver/inf/index',
                        ],
                        'icon' => 'angle-right',
                    ],
                    [
                        'label' => '硬件ID管理',
                        'can' => 'sidebar_inf_hid',
                        'url' => [
                            'driver/inf-hid/index',
                        ],
                        'icon' => 'angle-right',
                    ],
                ],
            ],
            [
                'label' => '系统管理',
                'url' => [
                    '#',
                ],
                'icon' => 'cog',
                'can' => 'sidebar_system',
                'options' => [
                    'class' => 'treeview rootTree',
                ],
                'items' => [
                    [
                        'label' => '管理系统授权项',
                        'can' => 'system_auth_manager',
                        'url' => [
                            'system/auth/index',
                        ],
                        'icon' => 'angle-right',
                    ],
                    [
                        'label' => '管理系统角色',
                        //'can' => 'system_role_manager',
                        'url' => [
                            'system/role/index',
                        ],
                        'icon' => 'angle-right',
                    ],
                    [
                        'label' => '管理系统用户',
                        'can' => 'system_user_manager',
                        'url' => [
                            'system/system-user/index',
                        ],
                        'icon' => 'angle-right',
                    ],
                ],
            ],
        ]),
    ]
) ?>

    </section>

</aside>
