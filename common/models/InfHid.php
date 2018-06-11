<?php

namespace common\models;

use Yii;

class InfHid extends \dbbase\models\InfHid
{
    public $driver_qd_name;
    public $driver_inf_name;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $rules = parent::rules();

        return array_merge(
            $rules,
            [
                [['driver_qd_name', 'driver_inf_name'], 'safe'],
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
                'id' => Yii::t('app', 'hid ID'),
                'driver_qd_name' => Yii::t('app', '包名称'),
                'driver_inf_name' => Yii::t('app', 'inf名称'),
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInf()
    {
        return $this->hasOne(Inf::className(), ['id' => 'inf_id']);
    }
}
