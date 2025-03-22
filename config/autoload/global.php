<?php

use Doctrine\DBAL\Driver\PDO\MySQL\Driver;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driver_class' => Driver::class,
                'params' => [
                    'host' => 'localhost', 
                    'port' => '3306',
                    'user' => 'root',
                    'password' => '',
                    'dbname' => 'kryty_pod_motor',
                ],
            ],
        ],
        'driver' => [
            'orm_default' => [
                'drivers' => [
                    'Application\Entity' => [
                        'class' => \Doctrine\ORM\Mapping\Driver\AttributeDriver::class,
                        'paths' => [__DIR__ . '/../../module/Application/src/Entity'],
                    ],
                ],
            ],
        ],
    ],
];
