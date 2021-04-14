<?php

use Slim\App;

return function (App $app) {

    $app->get('/', \App\Controller\HomeController::class);
    $app->get('/contact', \App\Controller\ContactController::class);

};