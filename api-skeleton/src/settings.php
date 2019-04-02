<?php
return [
    //setting settings for the routes
    'settings' => [
        'displayErrorDetails' => getenv('APP_DEBUG') ?? false,
        'debug' => getenv('APP_DEBUG') ?? false,
        'locale' => getenv('APP_LOCALE') ?? 'nl_BE',
        'addContentLengthHeader' => true,
        'httpVersion' => $_ENV['HTTP_VERSION'] ?? 2,
        'responseChunkSize' => 4096,
        'outputBuffering' => 'append',
        'determineRouteBeforeAppMiddleware' => false,
        'routerCacheFile' => false,

        //creates PDO
        'PDO' => [
            'dsn' => 'mysql:dbname=twitterdb;host=127.0.0.1',
            'login' => 'bavo',
            'password' => 'sql',
        ],

        //setting up logger (not being used atm)
        'logger' => [
            'name' => 'twitter',
            'level' => Monolog\Logger::DEBUG,
            'path' => __DIR__ . '/../logs/app.log',
        ],

    ],
];
