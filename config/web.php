<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'name' => 'Gestor de Prestaciones',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'language'=>'es',
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'XyoomMOzhOl2E11giRy83AMunPVLfehc',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        
        'registral'=> [
            'class' => $params['servicioRegistral'],//'app\components\ServicioRegistral'
        ],
        'lugar'=> [
            'class' => $params['servicioLugar'],//'app\components\ServicioLugar'
        ],
        
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages', // if advanced application, set @frontend/messages
                    'sourceLanguage' => 'es_ES',
                    'fileMap' => [
                        //'main' => 'main.php',
                    ],
                ],
            ],
            
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
//        'user' => [
//            'identityClass' => 'app\models\User',
//            'enableAutoLogin' => true,
//        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
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
            'enableStrictParsing' => false,
            'rules' => [
                
                ##### Backend #####
                [   #Programa
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'backend/programa', 
                ],
                [   #Tipo Recurso
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'backend/tipo-recurso', 
                ],
                [   #Tipo Recurso Has Programa
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'backend/programa-has-tipo-recurso', 
                ],
                
                ##### APIREST #####
                [   #Recurso Social
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/recurso', 
                    'extraPatterns' => [
                        'PUT baja-alumno' => 'baja-alumno',
                        'OPTIONS baja-alumno' => 'baja-alumno',
                        'PUT baja/{id}' => 'baja',
                        'OPTIONS baja/{id}' => 'baja',
                        'PUT acreditar/{id}' => 'acreditar',
                        'OPTIONS acreditar/{id}' => 'acreditar',
                        'POST filtrar-prestacion' => 'filtrar-prestacion',
                        'OPTIONS filtrar-prestacion' => 'filtrar-prestacion',
                    ], 
                ],
                [   #Export
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/export', 
                    'extraPatterns' => [
                        'GET exportarPrestacionesXls' => 'exportar-prestaciones-xls',
                        'OPTIONS exportarPrestaciones' => 'exportar-prestaciones',
                    ], 
                ],
                [   #beneficiario
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/beneficiario', 
                ],
                [   #cuota
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/cuota', 
                ],
                [   #Programa
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/programa', 
                    'extraPatterns' => [
                        'GET detalle' => 'detalle',
                        'OPTIONS detalle' => 'detalle',
                    ], 
                ],
                [   #Estadistica
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/estadistica', 
                    'extraPatterns' => [
                        'GET beneficiarios-por-programa-en-localidad/{localidadid}' => 'beneficiarios-por-programa-en-localidad',
                        'OPTIONS beneficiarios-por-programa-en-localidad/{localidadid}' => 'beneficiarios-por-programa-en-localidad',
                        'GET modulo-alimentario-por-localidad' => 'modulo-alimentario-por-localidad',
                        'OPTIONS modulo-alimentario-por-localidad' => 'modulo-alimentario-por-localidad',
                        'GET beneficiarios-por-tipo-recurso-en-localidad/{localidadid}' => 'beneficiarios-por-tipo-recurso-en-localidad',
                        'OPTIONS beneficiarios-por-tipo-recurso-en-localidad/{localidadid}' => 'beneficiarios-por-tipo-recurso-en-localidad',
                        'GET montos-por-localidades/{rango}' => 'montos-por-localidades',
                        'OPTIONS montos-por-localidades/{rango}' => 'montos-por-localidades',
                    ],
                    'tokens' => [ '{rango}' => '<rango:\\w+>', '{localidadid}'=>'<localidadid:\\w+>' ],
                ],
                [   #Tipo Recurso
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/tipo-recurso', 
                ],
                [   #Tipo Responsable
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/tipo-responsable', 
                ],
                [   #Usuario
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/usuario',   
                    'extraPatterns' => [
                        'POST login' => 'login',
                        'OPTIONS login' => 'options',
                        'OPTIONS listar-asignacion/{id}' => 'listar-asignacion',
                        'GET listar-asignacion/{id}' => 'listar-asignacion',
                        'OPTIONS crear-asignacion' => 'crear-asignacion',
                        'POST crear-asignacion' => 'crear-asignacion',
                        'OPTIONS borrar-asignacion' => 'borrar-asignacion',
                        'POST borrar-asignacion' => 'borrar-asignacion',
                        'OPTIONS baja/{id}' => 'baja',
                        'PUT baja/{id}' => 'baja',
                        'OPTIONS buscar-persona-por-cuil/{cuil}' => 'buscar-persona-por-cuil',
                        'GET buscar-persona-por-cuil/{cuil}' => 'buscar-persona-por-cuil',
                    ],
                    'tokens' => ['{id}'=>'<id:\\w+>', '{cuil}'=>'<cuil:\\w+>'],                       
                ],  
                [   #Permiso
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/permiso', 
                ],
                [   #Rol
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/rol', 
                ],
                
                ##### Interoperabilidad con Registral #####
                [   #persona
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/persona', 
                    'extraPatterns' => [
                        'GET buscar-por-documento/{nro_documento}' => 'buscar-por-documento',
                        'OPTIONS buscar-por-documento/{nro_documento}' => 'buscar-por-documento',
                        'PUT contacto/{id}' => 'contacto',
                        'OPTIONS contacto/{id}' => 'contacto',
                    ],
                    'tokens' => [ '{id}' => '<id:\\w+>', '{nro_documento}'=>'<nro_documento:\\w+>' ],
                ],
                [   #sexo
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/sexo', 
                ],
                [   #tipo-red-social
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/tipo-red-social', 
                ],
                [   #genero
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/genero', 
                ],
                [   #estado-civil
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/estado-civil', 
                ],
                /**HerramientaController**/
                [   'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/herramienta',
                    'extraPatterns' => [
                        'POST import' => 'import',
                    ], 
                ],
                
                ##### Interoperabilidad con Lugar#####
                [   #Localidad
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/localidad', 
                ],
                [   #Delegacion
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/delegacion', 
                ],
                [   #Municipio
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/municipio', 
                ],
                [   #Municipio
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'api/comision-fomento', 
                ],
            ],
        ],
        
    ],
    'params' => $params,
    
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableConfirmation'=> false,
            'enableRegistration'=> false,
            'enablePasswordRecovery'=> false,
            'admins'=>['admin']
        ],
        'rbac' => 'dektrium\rbac\RbacWebModule',
        
        "audit"=>[
            "class"=>"bedezign\yii2\audit\Audit",
            "ignoreActions" =>['audit/*', 'debug/*'],
            'userIdentifierCallback' => ['app\components\ServicioUsuarios', 'userIdentifierCallback'],
            'userFilterCallback' => ['app\components\ServicioUsuarios', 'userFilterCallback'],
            'accessIps'=>null,
            'accessUsers'=>null,
            'accessRoles'=>['admin','soporte']
        ],
        
        'api' => [
            'class' => 'app\modules\api\Api',
        ],
        
        'backend' => [
            'class' => 'app\modules\backend\Backend',
        ],
    ],
];

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
        'allowedIPs' => ['*'],
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
