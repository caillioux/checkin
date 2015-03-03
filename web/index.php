<?php

require_once __DIR__.'/../vendor/autoload.php'; 

$app = new Silex\Application();
$app['debug'] = true;

// Homepage controller
$app->get('/', function() use($app) { 
    return 'Ma page d\'accueil';
}); 

// Hello controller
$app->get('/hello/{name}', function($name) use($app) { 
    return 'Hello ' . $name;
}); 

// Sample controller
$app->get('/mon-blog-post', function() use($app) { 
    return 'Ici apparaitra le contenu du post';
}); 

// Admin event controller
$app->get('/admin/event/list', function() use($app) { 
    return 'Ici apparaitra la liste des événements';
}); 

// Admin contact controller
$app->get('/admin/contact/list', function() use($app) { 
    return 'Ici apparaitra la liste des contacts';
}); 


$app->run(); 
