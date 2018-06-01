<?php

namespace dbbase\models\yangsen;

use Yii;

/**
 * This is the model class for table "{{%customer_analysis}}".
 *
 * @property int $id ID
 * @property string $name 名称
 * @property int $age 年龄
 * @property int $gender 性别
 * @property string $height 身高
 * @property string $weigth 体重
 * @property string $occupation 职业
 * @property int $customer_type 顾客类型
 * @property int $target 使用对象
 * @property int $disease 是否有疾病史
 * @property string $disease_desc 疾病史描述
 * @property int $physical_state 身体状态
 * @property int $purchasing_power 购买力
 * @property string $remark 备注
 * @property string $created_at 创建时间
 * @property string $updated_at 编辑时间
 * @property int $is_del 是否删除
 */
class CustomerAnalysis extends \dbbase\models\ActiveRecordDelete
{
    const CUSTOMER = 1;
    const AGENT = 2;
    public static $types = [
        self::CUSTOMER => '顾客',
        self::AGENT => '代理',
    ];

    const OWN = 1;
    const FAMILY = 2;
    const FRIEND = 3;
    public static $targets = [
        self::OWN => '自用',
        self::FAMILY => '家人',
        self::FRIEND => '朋友',
    ];

    const NORMAL = 1;
    const PREGNANT = 2;
    const LACTATION = 3;
    public static $states = [
        self::NORMAL => '正常',
        self::PREGNANT => '备孕',
        self::LACTATION => '哺乳',
    ];

    const ONE = 1;
    const FIVE = 2;
    const TWENTY = 3;
    const FIFTY = 4;
    const HUNDRED = 5;
    const MORE = 6;
    public static $levels = [
        self::ONE => '单盒',
        self::FIVE => '5盒',
        self::TWENTY => '20盒',
        self::FIFTY => '50盒',
        self::HUNDRED => '100盒',
        self::MORE => '更多',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%customer_analysis}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['age', 'gender', 'customer_type', 'target', 'disease', 'physical_state', 'purchasing_power', 'consulting_number', 'is_del'], 'integer'],
            [['height', 'weigth'], 'number'],
            [['consulting_time', 'created_at', 'updated_at'], 'safe'],
            [['name', 'occupation', 'disease_desc', 'remark'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', '名称'),
            'age' => Yii::t('app', '年龄'),
            'gender' => Yii::t('app', '性别'),
            'height' => Yii::t('app', '身高'),
            'weigth' => Yii::t('app', '体重'),
            'occupation' => Yii::t('app', '职业'),
            'customer_type' => Yii::t('app', '顾客类型'),
            'target' => Yii::t('app', '使用对象'),
            'disease' => Yii::t('app', '是否有疾病史'),
            'disease_desc' => Yii::t('app', '疾病史描述'),
            'physical_state' => Yii::t('app', '身体状态'),
            'purchasing_power' => Yii::t('app', '购买力'),
            'remark' => Yii::t('app', '备注'),
            'consulting_time' => Yii::t('app', '咨询时间'),
            'consulting_number' => Yii::t('app', '咨询次数'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '编辑时间'),
            'is_del' => Yii::t('app', '是否删除'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDailies()
    {
        return $this->hasMany(CustomerDaily::className(), ['customer_id' => 'id']);
    }
}
