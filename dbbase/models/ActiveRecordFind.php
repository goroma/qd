<?php

namespace dbbase\models;

use Yii;

/**
 * 重定义数据库的一些写法.
 * Author: bobo.
 */
class ActiveRecordFind extends BaseActiveRecord
{
    /**
     * 重定义find方法,默认不查找已删除的数据.
     */
    public static function find()
    {
        return Yii::createObject(\yii\db\ActiveQuery::className(), [get_called_class()])->where(['is_del' => self::NOT_DEL]);
    }
}
