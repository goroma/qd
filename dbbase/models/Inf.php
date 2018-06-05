<?php

namespace dbbase\models;

use Yii;

/**
 * This is the model class for table "{{%inf}}".
 *
 * @property int $id ID
 * @property int $driver_id 包ID
 * @property string $class 驱动类型
 * @property string $driver_ver 版本
 * @property string $driver_original_pubtime 发布时间(未处理)
 * @property string $driver_pubtime 发布时间
 * @property string $driver_provider 驱动供应商
 * @property string $inf_name inf名称
 * @property string $inf_sha256 哈希值
 * @property string $created_at 创建时间
 * @property string $updated_at 编辑时间
 */
class Inf extends \dbbase\models\BaseActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%inf}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['driver_id'], 'integer'],
            [['driver_pubtime', 'created_at', 'updated_at'], 'safe'],
            [['class', 'driver_ver', 'driver_original_pubtime', 'driver_provider', 'inf_name'], 'string', 'max' => 255],
            [['inf_sha256'], 'string', 'max' => 1024],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'driver_id' => Yii::t('app', '包ID'),
            'class' => Yii::t('app', '驱动类型'),
            'driver_ver' => Yii::t('app', '版本'),
            'driver_original_pubtime' => Yii::t('app', '发布时间(未处理)'),
            'driver_pubtime' => Yii::t('app', '发布时间'),
            'driver_provider' => Yii::t('app', '驱动供应商'),
            'inf_name' => Yii::t('app', 'inf名称'),
            'inf_sha256' => Yii::t('app', '哈希值'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '编辑时间'),
        ];
    }
}
