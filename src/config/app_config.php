<?php
$app['base_url'] = function ($app) {
    $path = dirname($app['request']->getBaseUrl());
    return $app['request']->getSchemeAndHttpHost() . ($path !== '/' ? $path : '');
};

$app['controller_url'] = function ($app) {
    return $app['base_url'] . '/index.php';
};

$app['twig'] = $app->share($app->extend('twig', function($twig, $app) {
    $twig->addGlobal('projectName', 'Checkin');

    return $twig;
}));
