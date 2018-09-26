<?php

require __DIR__.'/dbConstants.php';

return [
    'propel' => [
        'database' => [
            'connections' => [
                'default' => [
                    'adapter'    => 'mysql',
                    'classname'  => 'Propel\Runtime\Connection\DebugPDO',
                    'dsn'        => sprintf('mysql:host=%s;dbname=%s',DB_HOST,DB_NAME),
                    'user'       => DB_USERNAME,
                    'password'   => DB_PASSWORD,
                    'attributes' => [],
						  'settings' => [
						     'charset' => 'utf8mb4',
							  'queries' => [
						        'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci, COLLATION_CONNECTION = utf8mb4_unicode_ci, COLLATION_DATABASE = utf8mb4_unicode_ci, COLLATION_SERVER = utf8mb4_unicode_ci'
							  ]
						  ]
                ]
            ]
        ],
        'runtime' => [
            'defaultConnection' => 'default',
            'connections' => ['default']
        ],
        'generator' => [
            'defaultConnection' => 'default',
            'connections' => ['default']
        ]
    ]
];
