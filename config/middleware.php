<?php

use Slim\App;
use Slim\Middleware\ErrorMiddleware;

return function (App $app) {
    // Parse JSON, form data, and XML
    $app->addBodyParsingMiddleware();
    // Add the Slim built-in routing middleware
    $app->addRoutingMiddleware();    
    $app->add(ErrorMiddleware::class);
};