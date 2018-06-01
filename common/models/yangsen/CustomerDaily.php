<?php

namespace common\models\yangsen;

use Yii;

class CustomerDaily extends \dbbase\models\yangsen\CustomerDaily
{
    public $customer_name;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $rules = parent::rules();

        return array_merge(
            $rules,
            [
                [['customer_name'], 'safe'],
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
                'customer_name' => Yii::t('app', '客户名称'),
            ]
        );
    }
}
