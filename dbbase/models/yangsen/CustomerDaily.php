<?php

namespace dbbase\models\yangsen;

use Yii;

/**
 * This is the model class for table "{{%customer_daily}}".
 *
 * @property int $id
 * @property int $customer_id
 * @property string $used_at
 * @property int $is_menstruation
 * @property int $is_bigu
 * @property int $is_stagnation
 * @property string $breakfast
 * @property string $lunch
 * @property string $afternoon_tea
 * @property string $dinner
 * @property string $morning_weight
 * @property string $night_weight
 * @property string $weight_diff
 * @property string $weight_loss
 * @property string $created_at
 * @property string $updated_at
 * @property int $is_del
 * @property CustomerAnalysis $customer
 */
class CustomerDaily extends \dbbase\models\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%customer_daily}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['customer_id'], 'required'],
            [['customer_id', 'is_menstruation', 'is_bigu', 'is_stagnation', 'is_del'], 'integer'],
            [['used_at', 'created_at', 'updated_at'], 'safe'],
            [['morning_weight', 'night_weight', 'weight_diff', 'weight_loss'], 'number'],
            [['breakfast', 'lunch', 'afternoon_tea', 'dinner'], 'string', 'max' => 255],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => CustomerAnalysis::className(), 'targetAttribute' => ['customer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'customer_id' => Yii::t('app', '客户'),
            'used_at' => Yii::t('app', '敷包日期'),
            'is_menstruation' => Yii::t('app', '经期'),
            'is_bigu' => Yii::t('app', '辟谷期'),
            'is_stagnation' => Yii::t('app', '平台期'),
            'breakfast' => Yii::t('app', '早餐'),
            'lunch' => Yii::t('app', '午餐'),
            'afternoon_tea' => Yii::t('app', '下午茶'),
            'dinner' => Yii::t('app', '晚餐'),
            'morning_weight' => Yii::t('app', '早上体重'),
            'night_weight' => Yii::t('app', '晚上体重'),
            'weight_diff' => Yii::t('app', '早晚体重差'),
            'weight_loss' => Yii::t('app', '合计减重'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '编辑时间'),
            'is_del' => Yii::t('app', '是否删除'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(CustomerAnalysis::className(), ['id' => 'customer_id']);
    }
}
