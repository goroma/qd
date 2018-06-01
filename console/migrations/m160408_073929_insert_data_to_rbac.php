<?php

use yii\db\Migration;

class m160408_073929_insert_data_to_rbac extends Migration
{
    const TB_NAME_AUTH_ITEM = '{{%auth_item}}';

    public function up()
    {
        // 增加是否能够删除权限
        $this->insert(self::TB_NAME_AUTH_ITEM, [
            'name' => 'is_has_del',
            'type' => '2',
            'description' => '是否能够删除',
            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    public function down()
    {
        $this->delete(self::TB_NAME_AUTH_ITEM, ['name' => 'is_has_del']);
    }
}
