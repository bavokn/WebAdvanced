<?php
use NilPortugues\Sql\QueryBuilder\Builder\GenericBuilder;

require __DIR__ . '/../vendor/autoload.php';

Dotenv\Dotenv::create(__DIR__.'./../')->load();

$settings = require __DIR__ . '/../src/settings.php';


$app = new \Slim\App($settings);

Laudis\Calculators\Registers\MainRegister::make()->register($app);


$app->run();
//$app->process(zRequest::createFromEnvironment($app->getContainer()['environment']), $app->getContainer()['response']);
