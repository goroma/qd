<?php

namespace backend\models\driver;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\driver\InfHid;

/**
 * InfHidSearch represents the model behind the search form about `backend\models\driver\InfHid`.
 */
class InfHidSearch extends InfHid
{
    public function rules()
    {
        return [
            [['id', 'driver_id', 'inf_id'], 'integer'],
            [['driver_qd_name', 'driver_inf_name', 'hid_name', 'hid', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = InfHid::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
        if ($this->driver_inf_name != null) {
            $query->joinWith('inf as i');
            $dataProvider->sort->attributes['i.inf_name'] = [
                'asc' => ['i.inf_name' => SORT_ASC],
                'desc' => ['i.inf_name' => SORT_DESC],
            ];
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'driver_id' => $this->driver_id,
            'inf_id' => $this->inf_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'hid_name', $this->hid_name])
            ->andFilterWhere(['like', 'd.qd_name', $this->driver_qd_name])
            ->andFilterWhere(['like', 'i.inf_name', $this->driver_inf_name])
            ->andFilterWhere(['like', 'hid', $this->hid]);

        return $dataProvider;
    }
}
