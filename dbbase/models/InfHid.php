<?php

namespace dbbase\models;

use Yii;

/**
 * This is the model class for table "{{%inf_hid}}".
 *
 * @property int $id ID
 * @property int $driver_id 包ID
 * @property int $inf_id inf ID
 * @property string $hid_name 硬件名称
 * @property string $hid 硬件ID
 * @property string $created_at 创建时间
 * @property string $updated_at 编辑时间
 */
class InfHid extends \dbbase\models\BaseActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%inf_hid}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['driver_id', 'inf_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['hid_name', 'hid'], 'string', 'max' => 255],
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
            'inf_id' => Yii::t('app', 'inf ID'),
            'hid_name' => Yii::t('app', '硬件名称'),
            'hid' => Yii::t('app', '硬件ID'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '编辑时间'),
        ];
    }
}
