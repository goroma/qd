<?php

namespace backend\models\driver;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\driver\DriverOs;

/**
 * DriverOsSearch represents the model behind the search form about `backend\models\driver\DriverOs`.
 */
class DriverOsSearch extends DriverOs
{
    public function rules()
    {
        return [
            [['id', 'driver_id'], 'integer'],
            [['qd_os', 'qd_pf', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = DriverOs::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'driver_id' => $this->driver_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'qd_os', $this->qd_os])
            ->andFilterWhere(['like', 'qd_pf', $this->qd_pf]);

        return $dataProvider;
    }
}
