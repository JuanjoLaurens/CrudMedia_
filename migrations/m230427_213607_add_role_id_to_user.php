<?php

use yii\db\Migration;

/**
 * Class m230427_213607_add_role_id_to_user
 */
class m230427_213607_add_role_id_to_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%usuario}}', 'rol_id', $this->integer()->notNull());

        // Añadir clave foránea
        $this->addForeignKey(
            'fk-usuario-rol_id',
            '{{%usuario}}',
            'rol_id',
            '{{%roles}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-usuario-rol_id', '{{%usuario}}');

        $this->dropColumn('{{%usuario}}', 'rol_id');
    }
}