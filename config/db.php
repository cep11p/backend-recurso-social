<?php

return [
    'class' => 'yii\db\Connection',
//    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'dsn' => 'mysql:host='.getenv('DB_HOST').';dbname='.getenv('DB_NAME'),
    'username' => 'root',
    'password' => getenv('DB_PASS'),
    'charset' => 'utf8',

    // Schema cache options (for production environment)
    //'enableSchemaCache' => true,
    //'schemaCacheDuration' => 60,
    //'schemaCache' => 'cache',
];
