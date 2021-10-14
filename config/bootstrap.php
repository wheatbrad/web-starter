<?php

use DI\ContainerBuilder;
use Slim\App;
use Slim\Middleware\ErrorMiddleware;

require_once APP_ROOT.'/vendor/autoload.php';

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__.'/container.php');
$container = $containerBuilder->build();
$app = $container->get(App::class);

// Register routes
(require APP_ROOT.'/app/routes.php')($app);

// Register middleware
$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();    
$app->add(ErrorMiddleware::class);

return $app;