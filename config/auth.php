<?php

use Yii;

$auth = Yii::$app->authManager;

// Crear el rol "admin"
$admin = $auth->createRole('admin');
$auth->add($admin);

// Crear el rol "usuario"
$usuario = $auth->createRole('usuario');
$auth->add($usuario);
