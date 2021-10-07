<?php

use Fullpipe\TwigWebpackExtension\WebpackExtension;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

return [
    'settings' => function () {
        return require __DIR__.'/settings.php';
    },

    App::class => function (ContainerInterface $container) {
        AppFactory::setContainer($container);

        return AppFactory::create();
    },

    ErrorMiddleware::class => function (ContainerInterface $container) {
        $app = $container->get(App::class);
        $settings = $container->get('settings')['error'];

        return new ErrorMiddleware(
            $app->getCallableResolver(),
            $app->getResponseFactory(),
            (bool) $settings['display_error_details'],
            (bool) $settings['log_errors'],
            (bool) $settings['log_error_details']
        );
    },

    Environment::class => function () {
        $loader = new FilesystemLoader(APP_ROOT.'/templates');
        $twig = new Environment($loader, [
            'cache' => APP_ROOT.'/tmp',
            'auto_reload' => true // should be false in production
        ]);
        
        $twig->addExtension(new WebpackExtension(
            APP_ROOT.'/public/manifest.json',
            APP_ROOT.'/public'
        ));

        return $twig;
    },

    PDO::class => function (ContainerInterface $container) {
        $settings = $container->get('settings')['db'];
        
        $host = $settings['host'];
        $dbname = $settings['database'];
        $username = $settings['username'];
        $password = $settings['password'];
        $charset = $settings['charset'];
        $flags = $settings['flags'];
        $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
        
        return new PDO($dsn, $username, $password, $flags);
    },

    ResponseFactoryInterface::class => function (ContainerInterface $container) {
        return $container->get(App::class)->getResponseFactory();
    }
];