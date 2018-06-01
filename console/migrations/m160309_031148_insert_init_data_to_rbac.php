<?php

use yii\db\Migration;

class m160309_031148_insert_init_data_to_rbac extends Migration
{
    const TB_NAME_AUTH_ITEM = '{{%auth_item}}';
    const TB_NAME_AUTH_ITEM_CHILD = '{{%auth_item_child}}';
    const TB_NAME_AUTH_ASSIGNMENT = '{{%auth_assignment}}';

    public function up()
    {
        // 添加角色
        $this->batchInsert(self::TB_NAME_AUTH_ITEM,
            ['name', 'type', 'description', 'created_at', 'updated_at'],
            [
                ['system_group_super_admin', 1, '超级管理员',   time(), time()],
                ['system_group_admin',       1, '管理员',       time(), time()],
            ]
        );

        // 给角色授权
        $this->insert(self::TB_NAME_AUTH_ITEM_CHILD, ['parent' => 'system_group_super_admin', 'child' => 'system_group_admin']);

        // 给用户分配角色
        $this->insert(self::TB_NAME_AUTH_ASSIGNMENT, ['item_name' => 'system_group_super_admin', 'user_id' => 1]);

        // 增加默认权限
        $this->batchInsert(self::TB_NAME_AUTH_ITEM,
            ['name', 'type', 'description', 'created_at', 'updated_at'],
            [
                ['check',            2, '审查',           time(), time()],
                ['is_has_del_power', 2, '是否有删除权限', time(), time()],
            ]
        );
    }

    public function down()
    {
        $this->execute('SET foreign_key_checks=0;');
        $this->truncateTable(self::TB_NAME_AUTH_ASSIGNMENT);
        $this->truncateTable(self::TB_NAME_AUTH_ITEM_CHILD);
        $this->truncateTable(self::TB_NAME_AUTH_ITEM);
        $this->execute('SET foreign_key_checks=1;');

        return true;
    }
}
