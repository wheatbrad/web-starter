<?php

use Fullpipe\TwigWebpackExtension\WebpackExtension;
use Psr\Container\ContainerInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

return [
    'settings' => function () {
        return require __DIR__.'/settings.php';
    },

    Environment::class => function () {
        $loader = new FilesystemLoader(APP_ROOT.'/app/View');
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
    }
];