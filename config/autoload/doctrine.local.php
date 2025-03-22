<?php
return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' => \Doctrine\DBAL\Driver\PDO\MySQL\Driver::class,
                'params' => [
                    'host'     => 'localhost',
                    'port'     => '3306',
                    'user'     => 'root',
                    'password' => '',
                    'dbname'   => 'kryty_pod_motor',
                    'charset'  => 'utf8mb4'
                ]
            ]
        ],
        'driver' => [
            'orm_default' => [
                'class' => \Doctrine\ORM\Mapping\Driver\AttributeDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../../module/Application/src/Entity'
                ]
            ]
        ],
        'configuration' => [
            'orm_default' => [
                'proxy_dir' => 'data/DoctrineORMModule/Proxy',
                'proxy_namespace' => 'DoctrineORMModule\Proxy',
            ]
        ]
    ]
];
