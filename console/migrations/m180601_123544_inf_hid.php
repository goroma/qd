<?php

use yii\db\Schema;
use yii\db\Migration;

class m180601_123544_inf_hid extends Migration
{
    const TB_NAME = '{{%inf_hid}}';

    public function safeUp()
    {
        $sql = 'DROP TABLE IF EXISTS '.self::TB_NAME;
        $this->execute($sql);

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB COMMENT=\'inf hid表\'';
        }

        $this->createTable(self::TB_NAME, [
            'id' => Schema::TYPE_UPK.' COMMENT \'ID\'',
            'driver_id' => Schema::TYPE_INTEGER.' UNSIGNED NOT NULL DEFAULT 0 COMMENT \'包ID\'',
            'inf_id' => Schema::TYPE_INTEGER.' UNSIGNED NOT NULL DEFAULT 0 COMMENT \'inf ID\'',
            'hid' => Schema::TYPE_STRING.' DEFAULT NULL COMMENT \'文件ID\'',
            'created_at' => Schema::TYPE_DATETIME.' DEFAULT NULL COMMENT \'创建时间\'',
            'updated_at' => Schema::TYPE_DATETIME.' DEFAULT NULL COMMENT \'编辑时间\'',
        ], $tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable(self::TB_NAME);
    }
}
