<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "calificacion".
 *
 * @property int $id
 * @property int $produccion_id
 * @property int $usuario_id
 * @property float $puntuacion
 *
 * @property Produccion $produccion
 * @property Usuario $usuario
 */
class Calificacion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'calificacion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['produccion_id', 'usuario_id', 'puntuacion'], 'required'],
            [['produccion_id', 'usuario_id'], 'integer'],
            [['puntuacion'], 'number'],
            [['produccion_id', 'usuario_id'], 'unique', 'targetAttribute' => ['produccion_id', 'usuario_id']],
            [['produccion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Produccion::class, 'targetAttribute' => ['produccion_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::class, 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'produccion_id' => 'Produccion ID',
            'usuario_id' => 'Usuario ID',
            'puntuacion' => 'Puntuacion',
        ];
    }

    /**
     * Gets query for [[Produccion]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduccion()
    {
        return $this->hasOne(Produccion::class, ['id' => 'produccion_id']);
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::class, ['id' => 'usuario_id']);
    }
}
