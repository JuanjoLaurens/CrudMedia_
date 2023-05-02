<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%produccion}}`.
 */
class m230427_205306_create_produccion_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%produccion}}', [
            'id' => $this->primaryKey(),
            'nombre' => $this->string()->notNull(),
            'tipo' => $this->string()->notNull(),
            'genero' => $this->string()->notNull(),
        ]);
        

        $this->createTable('{{%calificacion}}', [
            'id' => $this->primaryKey(),
            'produccion_id' => $this->integer()->notNull(),
            'usuario_id' => $this->integer()->notNull(),
            'puntuacion' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk_produccion_calificacion', '{{%calificacion}}', 'produccion_id', '{{%produccion}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_usuario_calificacion', '{{%calificacion}}', 'usuario_id', '{{%usuario}}', 'id', 'CASCADE', 'CASCADE');

        $this->createIndex('idx_produccion_nombre', '{{%produccion}}', 'nombre');
        $this->createIndex('idx_produccion_tipo', '{{%produccion}}', 'tipo');
        $this->createIndex('idx_produccion_genero', '{{%produccion}}', 'genero');
        $this->createIndex('idx_calificacion_produccion_usuario', '{{%calificacion}}', ['produccion_id', 'usuario_id'], true);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%calificacion}}');
        $this->dropTable('{{%produccion}}');
    }
}
