<?php declare(strict_types=1);

namespace App\Controller;

use App\Auth\SessionManager;
use App\Utilities\Utilities;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Twig\Environment;

/**
 * Controller for website home page
 */
final class PageController
{
    public function __construct(
        private Environment $twig,
        private SessionManager $session
    ) {}

    public function home(Request $request, Response $response): Response
    {
        $response->getBody()->write($this->twig->render('home.html.twig', [
            'session' => session_id(),
        ]));

        return $response;
    }

    public function protected(Request $request, Response $response): Response
    {
        if ($this->session->get('authenticated') !== null && $this->session->get('authenticated')) {
            $response->getBody()->write($this->twig->render('protected.html.twig', [
                'name' => $this->session->get('name')
            ]));

            return $response;
        } else {
            return $response->withHeader('Location', '/')->withStatus(302);
        }
    }
}