<?php

namespace dbbase\models;

use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

/**
 * 重定义数据库的一些写法.
 * Author: bobo.
 */
class BaseActiveRecord extends \yii\db\ActiveRecord
{
    /**
     * 性别.
     */
    const UNKNOWN = 0;
    const MALE = 1;
    const FEMALE = 2;

    /**
     * 性别信息映射.
     */
    public static $genderMap = [
        self::UNKNOWN => '保密',
        self::MALE => '男',
        self::FEMALE => '女',
    ];

    /**
     * 是否删除.
     */
    const IS_DEL = 1;
    const NOT_DEL = 0;

    /**
     * 是否删除状态映射.
     */
    public static $isDelMap = [
        self::IS_DEL => '已删除',
        self::NOT_DEL => '未删除',
    ];

    /**
     * 成功|失败.
     */
    const SUCCESS = 1;
    const FAIL = 0;

    /**
     * 成功|失败状态映射.
     */
    public static $isSuccessMap = [
        self::SUCCESS => '成功',
        self::FAIL => '失败',
    ];

    /**
     * 星期几.
     */
    const SUNDAY = 0;
    const MONDY = 1;
    const TUESDAY = 2;
    const WEDNESDAY = 3;
    const THURSDAY = 4;
    const FRIDAY = 5;
    const SATURDAY = 6;

    public static $weekMap = [
        self::SUNDAY => '星期日',
        self::MONDY => '星期一',
        self::TUESDAY => '星期二',
        self::WEDNESDAY => '星期三',
        self::THURSDAY => '星期四',
        self::FRIDAY => '星期五',
        self::SATURDAY => '星期六',
    ];

    const NO = 0;
    const YES = 1;
    public static $yesorno = [
        self::YES => '是',
        self::NO => '否',
    ];

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }
}
