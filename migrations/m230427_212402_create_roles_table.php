/** 
<?php

use yii\db\Migration;


class m230427_212402_create_roles_table extends Migration
{
    const TABLE_NAME = 'roles';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
            'id' => $this->primaryKey(),
            'name' => $this->string(64)->notNull(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);

        $this->batchInsert(self::TABLE_NAME, ['name', 'created_at'], [
            ['Admin', time()],
            ['Usuario', time()],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
    }
}
