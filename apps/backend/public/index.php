<?php

use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use TechnicalTest\backend\controllers\UserController;

require __DIR__ . '/../../../vendor/autoload.php';

$app = AppFactory::create();

$app->group('/users', static function (RouteCollectorProxy $group) {
    $group->get('/{id}', UserController::class . ':id');
    $group->put('/{id}', UserController::class . ':add');
});

$app->run();
