<?php

namespace dbbase\models;

use Yii;

/**
 * 重定义数据库的一些写法.
 * Author: bobo.
 */
class ActiveRecord extends BaseActiveRecord
{
    /**
     * 重定义delete方法,默认逻辑删除.
     */
    public function delete()
    {
        if ($this->hasAttribute('is_del') && !$this->isNewRecord) {
            $this->is_del = self::IS_DEL;

            return $this->save(false);
        }
    }

    /**
     * 重定义find方法,默认不查找已删除的数据.
     */
    public static function find()
    {
        return Yii::createObject(\yii\db\ActiveQuery::className(), [get_called_class()])->where(['is_del' => self::NOT_DEL]);
    }
}
