<?php

namespace common\models\common;

use yii\base\Model;

/**
 * common model class.
 */
class Common extends Model
{
    public static function getPhotoShow($photo_path)
    {
        if ($photo_path) {
            return \yii\helpers\Html::img($photo_path, ['class' => 'file-preview-image']);
        }
    }

    /**
     * 获取菜单列表里的权限.
     */
    public static function getMenuPermission($menus)
    {
        static $unsets;
        foreach ($menus as $menu) {
            $url = $menu['url'];
            if (isset($menu['can'])) {
                $unsets[] = $menu['can'];
            } elseif (isset($url[0]) && $url[0] != '#') {
                $unsets[] = $url[0];
            }

            if (isset($menu['items'])) {
                self::getMenuPermission($menu['items']);
            }
        }

        return $unsets;
    }

    /**
     * 判断是否是微信浏览器.
     */
    public static function isWeChatBrowser()
    {
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) {
            return true;
        }

        return false;
    }
}
