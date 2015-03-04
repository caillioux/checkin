<?php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Silex\Provider\FormServiceProvider;

$app = new Silex\Application(); 
$app['debug'] = true;

$app->register(new FormServiceProvider());

$app->mount('/form', include(__DIR__ . '/../src/Controllers/SampleForm.php'));

$app->run(); 
