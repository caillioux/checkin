<?php
$app['twig'] = $app->share($app->extend('twig', function($twig, $app) {
    $twig->addGlobal('projectName', 'Checkin');

    return $twig;
}));