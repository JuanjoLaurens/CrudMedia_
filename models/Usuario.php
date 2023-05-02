<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class Usuario extends ActiveRecord implements IdentityInterface
{
    const SCENARIO_CREAR = 'crear';
    const SCENARIO_ACTUALIZAR = 'actualizar';

    public static function tableName()
    {
        return '{{%usuario}}';
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREAR] = ['username', 'email', 'password', 'rol_id'];
        $scenarios[self::SCENARIO_ACTUALIZAR] = ['username', 'email', 'rol_id'];
        return $scenarios;
    }

    public function rules()
    {
        return [
            [['username', 'email', 'password', 'rol_id'], 'required'],
            [['username', 'email'], 'unique'],
            [['email'], 'email'],
            [['password'], 'string', 'min' => 6],
            [['rol_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Nombre de usuario',
            'email' => 'Correo electrónico',
            'password' => 'Contraseña',
            'rol_id' => 'Rol',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('findIdentityByAccessToken is not implemented.');
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
}
