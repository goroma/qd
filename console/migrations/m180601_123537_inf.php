<?php

use yii\db\Schema;
use yii\db\Migration;

class m180601_123537_inf extends Migration
{
    const TB_NAME = '{{%inf}}';

    public function safeUp()
    {
        $sql = 'DROP TABLE IF EXISTS '.self::TB_NAME;
        $this->execute($sql);

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB COMMENT=\'inf表\'';
        }

        $this->createTable(self::TB_NAME, [
            'id' => Schema::TYPE_UPK.' COMMENT \'ID\'',
            'driver_id' => Schema::TYPE_INTEGER.' UNSIGNED NOT NULL DEFAULT 0 COMMENT \'包ID\'',
            'class' => Schema::TYPE_STRING.' NOT NULL DEFAULT "" COMMENT \'驱动类型\'',
            'driver_ver' => Schema::TYPE_STRING.' NOT NULL DEFAULT "" COMMENT \'版本\'',
            'driver_original_pubtime' => Schema::TYPE_STRING.' DEFAULT NULL COMMENT \'发布时间(未处理)\'',
            'driver_pubtime' => Schema::TYPE_DATE.' DEFAULT NULL COMMENT \'发布时间\'',
            'driver_provider' => Schema::TYPE_STRING.' DEFAULT "" COMMENT \'驱动供应商\'',
            'inf_name' => Schema::TYPE_STRING.' DEFAULT "" COMMENT \'inf名称\'',
            'inf_sha256' => Schema::TYPE_STRING.'(1024) NOT NULL DEFAULT "" COMMENT \'哈希值\'',
            'created_at' => Schema::TYPE_DATETIME.' DEFAULT NULL COMMENT \'创建时间\'',
            'updated_at' => Schema::TYPE_DATETIME.' DEFAULT NULL COMMENT \'编辑时间\'',
        ], $tableOptions);

        $this->createIndex('inf_sha256', self::TB_NAME, ['inf_sha256'], false);
    }

    public function safeDown()
    {
        $this->dropIndex('inf_sha256', self::TB_NAME);

        $this->dropTable(self::TB_NAME);
    }
}
