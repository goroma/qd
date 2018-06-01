<?php

namespace backend\models\system;

/**
 * This is the model class for table "{{%user}}".
 */
class User extends \common\models\User
{
    public static function getUserNameById($id)
    {
        return self::find()->select('username')->where(['id' => $id])->one();
    }
}
