<?php

use yii\db\Schema;
use yii\db\Migration;

class m130524_201442_init extends Migration
{
    const TB_NAME = '{{%user}}';

    public function safeUp()
    {
        $sql = 'DROP TABLE IF EXISTS '.self::TB_NAME;
        $this->execute($sql);

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB COMMENT=\'用户表\'';
        }

        $this->createTable(self::TB_NAME, [
            'id' => Schema::TYPE_PK.'(11) NOT NULL AUTO_INCREMENT COMMENT \'主键ID\'',
            'name' => Schema::TYPE_STRING.' DEFAULT NULL COMMENT \'显示用户名\'',
            'username' => Schema::TYPE_STRING.' NOT NULL COMMENT \'登录用户名\'',
            'auth_key' => Schema::TYPE_STRING.'(32) NOT NULL DEFAULT "" COMMENT \'身份key\'',
            'password_hash' => Schema::TYPE_STRING.' NOT NULL COMMENT \'密码加密值\'',
            'password_reset_token' => Schema::TYPE_STRING.' DEFAULT NULL COMMENT \'密码重设token\'',
            'email' => Schema::TYPE_STRING.' NOT NULL COMMENT \'邮箱\'',
            'mobile' => Schema::TYPE_STRING.'(11) DEFAULT NULL COMMENT \'手机号\'',
            'classify' => Schema::TYPE_SMALLINT.'(2) NOT NULL DEFAULT 0 COMMENT \'用户分类,0:系统保留，1管理员\'',
            'access_token' => Schema::TYPE_STRING.' NOT NULL DEFAULT 0 COMMENT \'access_token\'',
            'role' => Schema::TYPE_SMALLINT.' NOT NULL DEFAULT 0 COMMENT \'角色\'',
            'status' => Schema::TYPE_SMALLINT.' NOT NULL DEFAULT 1 COMMENT \'状态\'',
            'created_at' => Schema::TYPE_DATETIME.' DEFAULT NULL COMMENT \'创建时间\'',
            'updated_at' => Schema::TYPE_DATETIME.' DEFAULT NULL COMMENT \'编辑时间\'',
            'is_del' => Schema::TYPE_SMALLINT.'(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT \'是否逻辑删除\'',
        ], $tableOptions);

        $this->createIndex('username', self::TB_NAME, ['username'], true);
        $this->createIndex('password_reset_token', self::TB_NAME, ['password_reset_token'], true);
        $this->createIndex('email', self::TB_NAME, ['email'], true);
    }

    public function safeDown()
    {
        $this->dropTable(self::TB_NAME);
    }
}
