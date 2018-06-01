<?php

namespace common\models\auth;

/**
 * This is the model class for table "auth_item".
 *
 * @property string $name
 * @property int $type
 * @property string $description
 * @property string $rule_name
 * @property string $data
 * @property int $created_at
 * @property int $updated_at
 * @property AuthAssignment[] $authAssignments
 * @property AuthRule $ruleName
 * @property AuthItemChild[] $authItemChildren
 */
class Auth extends \common\models\auth\AuthItem
{
    /**
     * 获取其它类型的权限,不是由菜单产生的.
     *
     * @return array $others key为name，description为value的一维数组
     */
    public static function getOtherPermissions()
    {
        $other_permissions = self::find()->where(['type' => self::OTHER_PERMISSION])->asArray()->all();

        $others = [];
        if (isset($other_permissions) && !empty($other_permissions)) {
            foreach ($other_permissions as $key => $value) {
                $others[$value['name']] = $value['description'];
            }
        }

        return $others;
    }
}
