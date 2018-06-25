<?php

use yii\db\Migration;

class m170125_131615_add_field_to_user extends Migration
{
    const TB_NAME = '{{%user}}';

    public function safeUp()
    {
        $this->addColumn(self::TB_NAME, 'localimgurl', 'string(255) DEFAULT \'http://image.blianb.com/admin_photo.jpg\' COMMENT \'用户头像本地图片链接\' AFTER mobile');
    }

    public function safeDown()
    {
        $this->dropColumn(self::TB_NAME, 'localimgurl');
    }
}
