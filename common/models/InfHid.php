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
    public function getOses()
    {
        return $this->hasMany(DriverOs::className(), ['driver_id' => 'id'])
            ->via('driver');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInf()
    {
        return $this->hasOne(Inf::className(), ['id' => 'inf_id']);
    }

    public function HdaudioSearch($hdaudio)
    {
        $hids = 0;
        if (substr_count($hdaudio, '&') < 2) {
            throw new \Exception('没有搜索到相关结果');
        }

        if (substr_count($hdaudio, '&') == 2) {
            $hids = $this->getInfHidCountByHid($hdaudio);
            if ($hids <= 0) {
                throw new \Exception('没有搜索到相关结果');
            }
        }

        if (substr_count($hdaudio, '&') == 3) {
            $hids = $this->getInfHidCountByHid($hdaudio);
            if ($hids <= 0) {
                $hdaudio_array = explode('&', $hdaudio);
                unset($hdaudio_array[3]);
                $hdaudio = implode('&', $hdaudio_array);
                $hids = $this->getInfHidCountByHid($hdaudio);
                if ($hids <= 0) {
                    throw new \Exception('没有搜索到相关结果');
                }
            }
        }

        if (substr_count($hdaudio, '&') > 4) {
            $pos = $this->getStrNPos($hdaudio, '&', 5);
            $hdaudio = substr($hdaudio, 0, $pos);
        }

        $hids = $this->getInfHidCountByHid($hdaudio);
        if ($hids <= 0) {
            $hdaudio_array = explode('&', $hdaudio);
            unset($hdaudio_array[5]);
            $new_hdaudio = implode('&', $hdaudio_array);
            $hids = $this->getInfHidCountByHid($new_hdaudio);
            if ($hids <= 0) {
                $hdaudio_array = explode('&', $hdaudio);
                unset($hdaudio_array[4]);
                $new_hdaudio = implode('&', $hdaudio_array);
                $hids = $this->getInfHidCountByHid($new_hdaudio);
                if ($hids <= 0) {
                    $hdaudio_array = explode('&', $hdaudio);
                    unset($hdaudio_array[5]);
                    unset($hdaudio_array[4]);
                    $new_hdaudio = implode('&', $hdaudio_array);
                    $hids = $this->getInfHidCountByHid($new_hdaudio);
                    if ($hids <= 0) {
                        throw new \Exception('没有搜索到相关结果');
                    }
                }
            }
        }

        return $hids;
    }

    public function getInfHidCountByHid($hdaudio)
    {
        //echo self::find()
            //->select(self::tableName().'.*')
            //->select(self::tableName().'.*, '.Driver::tableName().'.*, ds.*')
            //->joinWith(['driver d'])
            //->joinWith(['oses ds'])
            //->where(['d.is_del' => Driver::NOT_DEL])
            //->andWhere(['hid' => $hdaudio])
            //->createCommand()->getRawSql();
        return self::find()
            ->select(self::tableName().'.*')
            ->joinWith(['driver d'])
            ->andWhere(['hid' => $hdaudio])
            ->count();
    }

    public function getStrNPos($str, $needle, $num)
    {
        $n = 0;
        for($i = 1;$i <= $num;$i++) {
            $n = strpos($str, $needle, $n);
            $i != $num && $n++;
        }

        return $n;
    }
}
