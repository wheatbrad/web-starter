<?php

use App\Controller\PageController;
use Slim\App;

return function (App $app) {

    $app->get('/', [PageController::class, 'home']);
    $app->get('/login', [PageController::class, 'login']);
    $app->get('/logout', [PageController::class, 'logout']);
    $app->get('/protected', [PageController::class, 'protected']);

};