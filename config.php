<?php

return [

    /**
     * 默认使用的驱动
     */
    'default' => 'memcache',

    'connections' => [

        'redis' => [
            'host' => '127.0.0.1',
            'port' => 6379,
            'database' => 8,
            'password' => 'muyuzhouyu1M',
        ],

        'memcache' => [
            'host' => '127.0.0.1',
            'port' => 11211,
        ],

        'file' => [
            'path' => './storage/framework/cache',
        ],

    ]

];
