<?php

use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;
use TechnicalTest\backend\controllers\FindUserController;
use TechnicalTest\backend\controllers\SaveUserController;

require __DIR__ . '/../../../vendor/autoload.php';

$app = AppFactory::create();

$app->group('/users', static function (RouteCollectorProxy $group) {
    $group->get('/{id}', FindUserController::class . ':id');
    $group->put('/{id}', SaveUserController::class . ':add');
});

$app->run();
