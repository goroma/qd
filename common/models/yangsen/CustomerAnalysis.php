<?php

namespace common\models\yangsen;

use Yii;
use yii\helpers\ArrayHelper;

class CustomerAnalysis extends \dbbase\models\yangsen\CustomerAnalysis
{
    public $consulting_start;
    public $consulting_end;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $rules = parent::rules();

        return array_merge(
            $rules,
            [
                [['consulting_start', 'consulting_end'], 'safe'],
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
                'consulting_start' => Yii::t('app', '咨询开始时间'),
                'consulting_end' => Yii::t('app', '咨询结束时间'),
            ]
        );
    }

    /**
     * 获取所有客户.
     */
    public static function getAllCustomers()
    {
        return self::find()->where(['is_del' => self::NOT_DEL])->all();
    }

    public static function getAllCustomersArray()
    {
        return ArrayHelper::map(self::getAllCustomers(), 'id', 'name');
    }
}
