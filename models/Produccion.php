<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Produccion extends ActiveRecord
{
    const TIPO_PELICULA = 'pelicula';
    const TIPO_SERIE = 'serie';

    const SCENARIO_CREAR = 'crear';
    const SCENARIO_ACTUALIZAR = 'actualizar';

    public static function tableName()
    {
        return '{{%produccion}}';
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREAR] = ['nombre', 'tipo', 'genero'];
        $scenarios[self::SCENARIO_ACTUALIZAR] = ['nombre', 'tipo','genero', 'genero'];
        return $scenarios;
    }

    public $calificacion;

    public function rules()
    {
        return [
            [['nombre', 'tipo', 'genero'], 'required'],
            [['nombre'], 'string', 'max' => 255],
            [['tipo'], 'string', 'max' => 255],
            [['genero'], 'string', 'max' => 255],
            [['calificacion'], 'integer', 'min' => 1, 'max' => 5],
        ];
    }

    public function attributeLabels()
    {
        return [
            'nombre' => 'Título',
            'tipo' => 'Tipo',
            'genero' => 'Genero',
            'calificacion' => 'Calificación',
        ];
    }
}
