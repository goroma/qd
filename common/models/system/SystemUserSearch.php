<?php

namespace common\models\system;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * SystemUserSearch represents the model behind the search form about `boss\models\SystemUser`.
 */
class SystemUserSearch extends SystemUser
{
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = SystemUser::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query->andWhere(['<', 'role', 10]),
        ]);
        if (isset($params['ids'])) {
            $query->andWhere(['in', 'id', $params['ids']]);
        }

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['or',
                ['like', 'username', $this->username],
                ['like', 'email', $this->username],
                ['like', 'mobile', $this->username],
            ]);

        return $dataProvider;
    }
}
