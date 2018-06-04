<?php

use yii\db\Schema;
use yii\db\Migration;

class m180601_123038_driver extends Migration
{
    const TB_NAME = '{{%driver}}';

    public function safeUp()
    {
        $sql = 'DROP TABLE IF EXISTS '.self::TB_NAME;
        $this->execute($sql);

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB COMMENT=\'驱动包表\'';
        }

        $this->createTable(self::TB_NAME, [
            'id' => Schema::TYPE_UPK.' COMMENT \'ID\'',
            'qd_name' => Schema::TYPE_STRING.' NOT NULL DEFAULT "" COMMENT \'包名称\'',
            'qd_file_size' => Schema::TYPE_STRING.' NOT NULL DEFAULT "" COMMENT \'大小\'',
            'qd_sha256' => Schema::TYPE_STRING.'(1024) NOT NULL DEFAULT "" COMMENT \'哈希值\'',
            'qd_install_type' => Schema::TYPE_BOOLEAN.' UNSIGNED DEFAULT 0 COMMENT \'安装方式,0:未知,1:inf,2:exe\'',
            'qd_source' => Schema::TYPE_STRING.'(1024) DEFAULT NULL COMMENT \'来源\'',
            'qd_download_url' => Schema::TYPE_STRING.'(1024) DEFAULT NULL COMMENT \'下载地址\'',
            'qd_instruction' => Schema::TYPE_TEXT.' DEFAULT NULL COMMENT \'说明\'',
            'rank' => Schema::TYPE_BOOLEAN.' UNSIGNED DEFAULT 5 COMMENT \'权重\'',
            'language' => Schema::TYPE_STRING.' DEFAULT NULL COMMENT \'语言\'',
            'parameter' => Schema::TYPE_STRING.'(1024) DEFAULT NULL COMMENT \'参数\'',
            'note' => Schema::TYPE_STRING.'(1024) DEFAULT NULL COMMENT \'备注\'',
            'type' => Schema::TYPE_STRING.' DEFAULT NULL COMMENT \'类型\'',
            'created_at' => Schema::TYPE_DATETIME.' DEFAULT NULL COMMENT \'创建时间\'',
            'updated_at' => Schema::TYPE_DATETIME.' DEFAULT NULL COMMENT \'编辑时间\'',
            'is_del' => Schema::TYPE_BOOLEAN.' UNSIGNED DEFAULT 0 COMMENT \'是否删除\'',
        ], $tableOptions);

        $this->createIndex('qd_sha256', self::TB_NAME, ['qd_sha256'], false);
    }

    public function safeDown()
    {
        $this->dropIndex('qd_sha256', self::TB_NAME);

        $this->dropTable(self::TB_NAME);
    }
}
