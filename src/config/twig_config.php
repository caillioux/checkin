<?php
// Register twig
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../views',
));
$app['twig'] = $app->share($app->extend('twig', function($twig, $app) {
    $twig->addGlobal('baseUrl', $app['base_url']);
    $twig->addGlobal('baseController', $app['controller_url']);

    return $twig;
}));