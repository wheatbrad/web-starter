<?php declare(strict_types=1);

namespace App\Controller;

use App\Service\UserService;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class UserController
{
    public function __construct(private UserService $userService) {}

    public function login(Request $request, Response $response): Response
    {

        // TODO: if login is successful where do we send user?

        return $response;
    }

    public function logout(Request $request, Response $response): Response
    {
        $this->sessionManager->destroy();
        // update database ??

        return $response;
    }

    public function updatePassword(Request $request, Response $response): Response
    {
        return $response;
    }
}