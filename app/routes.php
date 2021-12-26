<?php

use App\Controller\PageController;
use App\Controller\UserController;
use Slim\App;

return function (App $app) {

    $app->get('/', [PageController::class, 'home']);
    $app->get('/protected', [PageController::class, 'protected']);
    $app->get('/user/login', [UserController::class, 'login']);
    $app->get('/user/logout', [UserController::class, 'logout']);

};