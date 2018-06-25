<?php

namespace api\modules\v1\models;

use yii\data\ActiveDataProvider;

class Driver extends \common\models\driver\Driver
{
    public function fields()
    {
        $fields = parent::fields();

        $extraFields = [
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
