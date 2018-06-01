<?php

namespace backend\models\yangsen;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CustomerDailySearch represents the model behind the search form about `backend\models\yangsen\CustomerDaily`.
 */
class CustomerDailySearch extends CustomerDaily
{
    public function rules()
    {
        return [
            [['id', 'customer_id', 'is_menstruation', 'is_bigu', 'is_stagnation', 'is_del'], 'integer'],
            [['customer_name', 'used_at', 'breakfast', 'lunch', 'afternoon_tea', 'dinner', 'created_at', 'updated_at'], 'safe'],
            [['morning_weight', 'night_weight', 'weight_diff', 'weight_loss'], 'number'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = CustomerDaily::find()->from(['cd' => self::tableName()])->where(['cd.is_del' => self::NOT_DEL]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'used_at' => $this->used_at,
            'is_menstruation' => $this->is_menstruation,
            'is_bigu' => $this->is_bigu,
            'is_stagnation' => $this->is_stagnation,
            'morning_weight' => $this->morning_weight,
            'night_weight' => $this->night_weight,
            'weight_diff' => $this->weight_diff,
            'weight_loss' => $this->weight_loss,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        if ($this->customer_name != null) {
            $query->joinWith('customer as ca')->andWhere(['ca.is_del' => self::NOT_DEL]);
            $dataProvider->sort->attributes['customer.customer_name'] = [
                'asc' => ['ca.customer_name' => SORT_ASC],
                'desc' => ['ca.customer_name' => SORT_DESC],
            ];
        }

        $query->andFilterWhere(['like', 'breakfast', $this->breakfast])
            ->andFilterWhere(['like', 'lunch', $this->lunch])
            ->andFilterWhere(['like', 'ca.name', $this->customer_name])
            ->andFilterWhere(['like', 'afternoon_tea', $this->afternoon_tea])
            ->andFilterWhere(['like', 'dinner', $this->dinner]);

        return $dataProvider;
    }
}
