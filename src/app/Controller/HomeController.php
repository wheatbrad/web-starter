<?php declare(strict_types=1);

namespace App\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Controller for website home page
 */
final class HomeController
{
    public function __construct()
    {
        
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        $response->getBody()->write('Home page');

        return $response;
    }
}