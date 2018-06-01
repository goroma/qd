<?php

namespace backend\components;

use Yii;
use yii\base\Component;
use common\models\auth\AuthItem;

/**
 * @author bobo
 */
class RbacHelper extends Component
{
    const CACHE_MENU = 'xsystem-menus';
    const CACHE_TOP_MENU = 'xsystem-top-menus';
    const CONFIG_VERSION = 'xsystem-rbac-config-version';

    /**
     * 处理左菜单.
     *
     * @param array $menus
     */
    public static function menu($menus)
    {
        $_menus = self::getMenus();
        $cver = Yii::$app->cache->get(self::CONFIG_VERSION);
        $sver = Yii::$app->cache->get(self::CONFIG_VERSION.Yii::$app->session->id);
        if (empty($_menus) || $cver != $sver) {
            $menus = self::recursiveInitMenu($menus);
            $cver = Yii::$app->cache->get(self::CONFIG_VERSION);
            Yii::$app->cache->set(self::CONFIG_VERSION.Yii::$app->session->id, $cver, 3600 * 2);
            $result = Yii::$app->cache->set(self::CACHE_MENU.Yii::$app->session->id, $menus, 3600 * 2);

            return $menus;
        }

        return $_menus;
    }

    /**
     * 处理顶部菜单.
     *
     * @param array $menus
     */
    public static function topMenu($menus)
    {
        $_menus = self::getTopMenus();
        if (empty($_menus)) {
            $menus = self::recursiveInitMenu($menus);
            Yii::$app->cache->set(self::CACHE_TOP_MENU.Yii::$app->session->id, $menus, 3600 * 2);

            return $menus;
        }

        return $_menus;
    }

    /**
     * 递归初始化菜单.
     */
    private static function recursiveInitMenu($menus)
    {
        $auth = Yii::$app->authManager;
        foreach ($menus as $key => $menu) {
            $url = $menu['url'];
            if (isset($menu['can'])) {
                $name = $menu['can'];
            } elseif (isset($url[0]) && $url[0] != '#') {
                $name = $url[0];
            }
            if (!empty($name)) {
                $permission = $auth->getPermission($name);
                if (empty($permission)) {
                    $permission = $auth->createPermission($name);
                    $permission->description = $menu['label'];
                    $auth->add($permission);
                    $admin = $auth->getRole(AuthItem::SYSTEM_ROLE_SUPER_ADMIN);
                    $auth->addChild($admin, $permission);
                }
                $menu['visible'] = Yii::$app->user->can($name);
            }
            if (isset($menu['items'])) {
                $menu['items'] = self::recursiveInitMenu($menu['items']);
            }
            $menus[$key] = $menu;
        }

        return $menus;
    }

    /**
     * 获取左侧菜单.
     */
    public static function getMenus()
    {
        return Yii::$app->cache->get(self::CACHE_MENU.Yii::$app->session->id);
    }

    /**
     * 获取顶部菜单.
     */
    public static function getTopMenus()
    {
        return Yii::$app->cache->get(self::CACHE_TOP_MENU.Yii::$app->session->id);
    }

    /**
     * 权限修改时调用此方法.
     */
    public static function updateConfigVersion()
    {
        $key = time();
        Yii::$app->cache->set(self::CONFIG_VERSION, $key);
    }
}
