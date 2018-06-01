<?php

namespace backend\models\system;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "auth_assignment".
 */
class AuthAssignment extends \common\models\auth\AuthAssignment
{
    /**
     * 获取对应角色下的用户.
     *
     * @param string $role 角色
     *
     * @return array $user    用户信息
     */
    public static function getUserByRole($role = '')
    {
        $object = self::find()
            ->select('u.username, u.id')
            ->leftJoin(User::tableName().' u', self::tableName().'.user_id = u.id');

        if ($role != '') {
            $object->where(['item_name' => $role, 'u.status' => 1]);
        } else {
            $object->where(['u.status' => 1]);
        }

        $user = $object->asArray()
            ->all();

        $users = ArrayHelper::map($user, 'id', 'username');

        return $users;
    }
}
