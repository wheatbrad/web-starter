<?php

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;

require APP_ROOT.'/vendor/autoload.php';

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions(__DIR__.'/container.php');
$container = $containerBuilder->build();

AppFactory::setContainer($container);
$app = AppFactory::create();

// Register routes
(require APP_ROOT.'/app/routes.php')($app);

// Get error settings from container
$e = $container->get('settings')['error'];

// Register middleware
$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->addErrorMiddleware(
    $e['display_error_details'],
    $e['log_errors'],
    $e['log_error_details'],
);

return $app;