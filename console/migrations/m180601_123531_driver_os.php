<?php

use yii\db\Schema;
use yii\db\Migration;

class m180601_123531_driver_os extends Migration
{
    const TB_NAME = '{{%driver_os}}';

    public function safeUp()
    {
        $sql = 'DROP TABLE IF EXISTS '.self::TB_NAME;
        $this->execute($sql);

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB COMMENT=\'驱动包操作系统表\'';
        }

        $this->createTable(self::TB_NAME, [
            'id' => Schema::TYPE_UPK.' COMMENT \'ID\'',
            'driver_id' => Schema::TYPE_INTEGER.' UNSIGNED NOT NULL DEFAULT 0 COMMENT \'包ID\'',
            'driver_from' => Schema::TYPE_BOOLEAN.' UNSIGNED DEFAULT 0 COMMENT \'来源,0:未知,1:手动书写,2:inf分析\'',
            'qd_os' => Schema::TYPE_STRING.' NOT NULL DEFAULT "" COMMENT \'支持的操作系统\'',
            'qd_os_bit' => Schema::TYPE_STRING.'(32) DEFAULT "" COMMENT \'操作系统位数\'',
            'created_at' => Schema::TYPE_DATETIME.' DEFAULT NULL COMMENT \'创建时间\'',
            'updated_at' => Schema::TYPE_DATETIME.' DEFAULT NULL COMMENT \'编辑时间\'',
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable(self::TB_NAME);
    }
}
