<?php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;

$app = new Silex\Application(); 
$app['debug'] = true;

require_once __DIR__.'/../src/config/form_config.php';

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../src/views',
));

$app->mount('/form', include(__DIR__ . '/../src/Controllers/SampleFormController.php'));

$app->run(); 
