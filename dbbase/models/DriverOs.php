<?php

namespace dbbase\models;

use Yii;

/**
 * This is the model class for table "{{%driver_os}}".
 *
 * @property int $id ID
 * @property int $driver_id 包ID
 * @property string $qd_os 操作系统
 * @property string $qd_pf 平台
 * @property string $created_at 创建时间
 * @property string $updated_at 编辑时间
 */
class DriverOs extends \dbbase\models\BaseActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%driver_os}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['driver_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['qd_os'], 'string', 'max' => 255],
            [['qd_pf'], 'string', 'max' => 32],
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
            'qd_os' => Yii::t('app', '操作系统'),
            'qd_pf' => Yii::t('app', '平台'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '编辑时间'),
        ];
    }
}
