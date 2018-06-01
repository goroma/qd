<?php

namespace backend\models\system;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * This is the model class for table "auth_assignment".
 */
class AuthAssignmentSearch extends AuthAssignment
{
    public function rules()
    {
        return [
            [['item_name'], 'safe'],
            [['user_id', 'created_at'], 'integer'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search()
    {
        $query = AuthAssignment::find();

        // 联合查询
        $query->joinWith(['user u']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        //if (!($this->load($params) && $this->validate())) {
            //return $dataProvider;
        //}

        $query->andFilterWhere([
            'item_name' => $this->item_name,
            'created_at' => $this->created_at,
        ]);

        return $query->createCommand()->getRawSql();

        return $dataProvider;
    }
}
