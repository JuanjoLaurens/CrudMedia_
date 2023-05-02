<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%calificacion}}`.
 */
class m230427_205445_create_calificacion_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%calificacion}}', [
            'id' => $this->primaryKey(),
            'produccion_id' => $this->integer()->notNull(),
            'usuario_id' => $this->integer()->notNull(),
            'puntuacion' => $this->float()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-calificacion-produccion_id',
            'calificacion',
            'produccion_id',
            'produccion',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-calificacion-usuario_id',
            'calificacion',
            'usuario_id',
            'usuario',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-calificacion-produccion_id-usuario_id',
            'calificacion',
            ['produccion_id', 'usuario_id'],
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-calificacion-usuario_id', 'calificacion');
        $this->dropForeignKey('fk-calificacion-produccion_id', 'calificacion');
        $this->dropTable('{{%calificacion}}');
    }
}
