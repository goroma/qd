<?php

namespace common\models;

use Yii;

class Driver extends \dbbase\models\Driver
{
    public $driver_file;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $rules = parent::rules();

        return array_merge(
            $rules,
            [
                [['driver_file'], 'safe'],
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
                'driver_file' => Yii::t('app', '上传包文件'),
            ]
        );
    }
}
