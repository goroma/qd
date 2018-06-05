<?php

namespace backend\models\driver;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\driver\Driver;

/**
 * DriverSearch represents the model behind the search form about `backend\models\driver\Driver`.
 */
class DriverSearch extends Driver
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['qd_name', 'qd_file_size', 'qd_sha256', 'qd_install_type', 'qd_source', 'qd_download_url', 'qd_instruction', 'rank', 'language', 'parameter', 'note', 'type', 'created_at', 'updated_at', 'is_del'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Driver::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'qd_name', $this->qd_name])
            ->andFilterWhere(['like', 'qd_file_size', $this->qd_file_size])
            ->andFilterWhere(['like', 'qd_sha256', $this->qd_sha256])
            ->andFilterWhere(['like', 'qd_install_type', $this->qd_install_type])
            ->andFilterWhere(['like', 'qd_source', $this->qd_source])
            ->andFilterWhere(['like', 'qd_download_url', $this->qd_download_url])
            ->andFilterWhere(['like', 'qd_instruction', $this->qd_instruction])
            ->andFilterWhere(['like', 'rank', $this->rank])
            ->andFilterWhere(['like', 'language', $this->language])
            ->andFilterWhere(['like', 'parameter', $this->parameter])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'is_del', $this->is_del]);

        return $dataProvider;
    }
}
