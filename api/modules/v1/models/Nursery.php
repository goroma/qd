<?php

namespace api\modules\v1\models;

use yii\data\ActiveDataProvider;
use common\models\system\SystemUser as User;

class Nursery extends \common\models\nursery\Nursery
{
    public function fields()
    {
        $fields = parent::fields();

        $extraFields = [
            'nursery_logo' => function ($model) {
                $logo = $model->nurseryLogo;
                if ($logo) {
                    return $logo->nursery_pic;
                } else {
                    return '';
                }
            },
        ];
        $fields = array_merge($fields, $extraFields);

        return $fields;
    }

    public static function getNurseryList($accessToken)
    {
        $user = User::findIdentityByAccessToken($accessToken);

        $query = self::find()->andWhere(['user_id' => $user->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }

    public static function saveNursery($model, $accessToken)
    {
        $user = User::findIdentityByAccessToken($accessToken);
        $model->link('user', $user);
        if ($model->save(false)) {
            return self::findOne($model->id);
        } else {
            return null;
        }
    }
}
