<?php

namespace common\models;

use Yii;

class Inf extends \dbbase\models\Inf
{
    public $driver_qd_name;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $rules = parent::rules();

        return array_merge(
            $rules,
            [
                [['driver_qd_name'], 'safe'],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();

        return array_merge(
            $labels,
            [
                'id' => Yii::t('app', 'inf ID'),
                'driver_qd_name' => Yii::t('app', '包名称'),
            ]
        );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDriver()
    {
        return $this->hasOne(Driver::className(), ['id' => 'driver_id']);
    }
}
