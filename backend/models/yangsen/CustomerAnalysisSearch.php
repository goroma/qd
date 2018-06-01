<?php

namespace backend\models\yangsen;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CustomerAnalysisSearch represents the model behind the search form about `backend\models\yangsen\CustomerAnalysis`.
 */
class CustomerAnalysisSearch extends CustomerAnalysis
{
    public function rules()
    {
        return [
            [['id', 'age', 'gender', 'customer_type', 'target', 'disease', 'physical_state', 'purchasing_power', 'consulting_number', 'is_del'], 'integer'],
            [['name', 'occupation', 'disease_desc', 'remark', 'consulting_time', 'consulting_start', 'consulting_end', 'created_at', 'updated_at'], 'safe'],
            [['height', 'weigth'], 'number'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = CustomerAnalysis::find()->where(['is_del' => self::NOT_DEL]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'age' => $this->age,
            'gender' => $this->gender,
            'height' => $this->height,
            'weigth' => $this->weigth,
            'customer_type' => $this->customer_type,
            'target' => $this->target,
            'disease' => $this->disease,
            'physical_state' => $this->physical_state,
            'purchasing_power' => $this->purchasing_power,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'is_del' => $this->is_del,
        ]);

        if ($this->consulting_start != null) {
            $query->andFilterWhere(['>=', 'consulting_time', $this->consulting_start]);
        }
        if ($this->consulting_end != null) {
            $query->andFilterWhere(['<=', 'consulting_time', $this->consulting_end]);
        }
        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'occupation', $this->occupation])
            ->andFilterWhere(['like', 'disease_desc', $this->disease_desc])
            ->andFilterWhere(['like', 'remark', $this->remark]);

        return $dataProvider;
    }
}
