<?php

namespace dbbase\models;

/**
 * 重定义数据库的一些写法.
 * Author: bobo.
 */
class ActiveRecordDelete extends BaseActiveRecord
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
}
