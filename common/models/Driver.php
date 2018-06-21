<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

class Driver extends \dbbase\models\Driver
{
    public $driver_file;
    public $driver_os;
    public $driver_inf;

    const UNKNOWN = 0;
    const INF = 1;
    const EXE = 2;
    public static $install_type = [
        self::UNKNOWN => '未知',
        self::INF => 'inf安装',
        self::EXE => 'exe安装',
    ];

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $rules = parent::rules();

        return array_merge(
            $rules,
            [
                [['driver_file', 'driver_os', 'driver_inf'], 'safe'],
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
                'qd_install_type' => Yii::t('app', '安装方式'),
                'driver_os' => Yii::t('app', '包操作系统'),
                'driver_inf' => Yii::t('app', '包INF'),
            ]
        );
    }

    public static function getAllDriver()
    {
        return self::find()->all();
    }

    public static function getAllDriverArray()
    {
        return ArrayHelper::map(self::getAllDriver(), 'id', 'qd_name');
    }

    public function getOses()
    {
        return $this->hasMany(DriverOs::className(), ['driver_id' => 'id']);
    }

    public function getInfs()
    {
        return $this->hasMany(Inf::className(), ['driver_id' => 'id']);
    }

    public function driverSearchHash($hash)
    {
        $response = [
            'qd_name' => '',
            'qd_file_size' => '',
            'hash' => '',
            'qd_install_type' => '',
            'qd_instruction' => '',
            'qd_download_url' => [],
        ];
        $driver = Driver::findOne([
            'qd_sha256' => $hash,
            'is_del' => Driver::NOT_DEL,
        ]);
        if (!$driver) {
            throw new \Exception('驱动不存在,请重新搜索');
        }

        $response['qd_name'] = $driver->qd_name;
        $response['qd_file_size'] = round($driver->qd_file_size > 0 ? ($driver->qd_file_size / (1024 * 1024)) : 0, 1).'MB';
        $response['hash'] = $driver->qd_sha256;
        $response['qd_install_type'] = Driver::$install_type[$driver->qd_install_type];
        $response['qd_instruction'] = $driver->qd_instruction;
        $response['qd_download_url'] = explode(',', $driver->qd_download_url);

        return $response;
    }
}
