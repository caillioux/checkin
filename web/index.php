<?php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Silex\Provider\FormServiceProvider;

$app = new Silex\Application(); 
$app['debug'] = true;

$app->register(new FormServiceProvider());

$app->get('/hello/{name}', function($name) use($app) { 
    return 'Hello '.$app->escape($name); 
}); 

$app->mount('/form', include(__DIR__ . '/../src/Controllers/SampleForm.php'));

$app->run(); 
