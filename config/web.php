<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [

        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],

        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '7PL4bxrgwZjm-b-qel2Q16Dj-juuREPF',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        'user' => [
            'identityClass' => 'app\models\Usuario',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@app/mail',
            // send all mails to a file by default.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                // Ruta para el listado de usuarios
                'usuarios' => 'usuario/index',
                // Ruta para ver un usuario en particular
                'usuario/<id:\d+>' => 'usuario/view',
                // Ruta para crear un nuevo usuario
                'usuario/nuevo' => 'usuario/create',
                // Ruta para actualizar un usuario existente
                'usuario/<id:\d+>/editar' => 'usuario/update',
                // Ruta para eliminar un usuario existente
                'usuario/<id:\d+>/eliminar' => 'usuario/delete',
                // Ruta para el listado de producciones
                'producciones' => 'produccion/index',
                // Ruta para ver una produccion en particular
                'produccion/<id:\d+>' => 'produccion/view',
                // Ruta para crear una nueva produccion
                'produccion/nueva' => 'produccion/create',
                // Ruta para actualizar una produccion existente
                'produccion/<id:\d+>/editar' => 'produccion/update',
                // Ruta para eliminar una produccion existente
                'produccion/<id:\d+>/eliminar' => 'produccion/delete',
                // Ruta para buscar y filtrar producciones
                'produccion/buscar' => 'produccion/buscar',
                // Ruta para calificar una produccion
                'produccion/<id:\d+>/calificar/<calificacion:\d+>' => 'produccion/calificar',

                // Ruta para el reductor
                'produccion/reduce-string' => 'produccion/reduce-string',
            ],

        ],

    ],
    'params' => $params,
];


// $auth = $config['components']['authManager'];
// $auth->removeAll(); // eliminar los datos anteriores del RBAC (en caso de haberlos)
// $admin = $auth->createRole('admin');
// $auth->add($admin);
// $user = $auth->createRole('user');
// $auth->add($user);
// $calificar = $auth->createPermission('calificar');
// $auth->add($calificar);
// $admin->addChild($calificar);
// $admin->addChild($auth->createPermission('crear'));
// $admin->addChild($auth->createPermission('editar'));
// $admin->addChild($auth->createPermission('eliminar'));
// $user->addChild($calificar);

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
