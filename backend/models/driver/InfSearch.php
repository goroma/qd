<?php

namespace backend\models\driver;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\driver\Inf;

/**
 * InfSearch represents the model behind the search form about `backend\models\driver\Inf`.
 */
class InfSearch extends Inf
{
    public function rules()
    {
        return [
            [['id', 'driver_id'], 'integer'],
            [['driver_qd_name', 'class', 'driver_ver', 'driver_original_pubtime', 'driver_pubtime', 'driver_provider', 'inf_name', 'inf_sha256', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Inf::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query->orderBy(['id' => SORT_DESC]),
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        if ($this->driver_qd_name != null) {
            $query->joinWith('driver as d');
            $dataProvider->sort->attributes['d.qd_name'] = [
                'asc' => ['d.qd_name' => SORT_ASC],
                'desc' => ['d.qd_name' => SORT_DESC],
            ];
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'driver_id' => $this->driver_id,
            'driver_pubtime' => $this->driver_pubtime,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'class', $this->class])
            ->andFilterWhere(['like', 'driver_ver', $this->driver_ver])
            ->andFilterWhere(['like', 'driver_original_pubtime', $this->driver_original_pubtime])
            ->andFilterWhere(['like', 'driver_provider', $this->driver_provider])
            ->andFilterWhere(['like', 'inf_name', $this->inf_name])
            ->andFilterWhere(['like', 'd.qd_name', $this->driver_qd_name])
            ->andFilterWhere(['like', 'inf_sha256', $this->inf_sha256]);

        return $dataProvider;
    }
}
