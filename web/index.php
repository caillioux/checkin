<?php

require_once __DIR__.'/../vendor/autoload.php'; 

$app = new Silex\Application(); 
$app['debug'] = true;

// Register twig
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../src/Views',
));


// Main controller
$app->get('/hello/{name}', function($name) use($app) { 
    return $app['twig']->render('layout.html.twig', array(
        'name' => $name,
    ));
}); 

$app->run(); 
