<?php

return [
    'host' => 'YOUR_HOST',
    'dbname' => 'YOUR_DATABASE_NAME',
    'username' => 'YOUR_DATABASE_USERNAME',
    'password' => 'YOUR_DATABASE_PASSWORD',
];

/*** You can have multiple database credentials defined and switch to whatever database you want to use easily as demonstrated in the example below ***/
/*

$db_creds = [
    'localhost' => [
        'host' => 'localhost',
        'dbname' => 'local_db',
        'username' => 'root',
        'password' => '',
    ],
    'remote_host' => [
        'host' => 'remote-host.com',
        'dbname' => 'remote_db',
        'username' => 'db_username',
        'password' => 'test123',
    ],
];

return $db_creds['remote_host'];  //whatever database credentials you want to use

*/
