<?php
require_once __DIR__.'/../vendor/autoload.php'; 

$app = new Silex\Application();
$app['debug'] = true;

// Load database connexion configuration
require_once __DIR__.'/../src/config/pdo_config.php';

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


// First PDO based controller: prepared query
$app->get('/pdo/{id}', function($id) use($app) { 
    // get a contact
    $sql = "SELECT nom, prenom FROM contact WHERE id = :id";
    $stmt = $app['pdo']->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $contact = $stmt->fetch();

    return 'Hello '.$app->escape($contact['prenom'] . ' ' . $contact['nom']); 
})->assert('id', '\d+'); 


// Second PDO based controller: simple query
$app->get('/pdo/{name}', function($name) use($app) { 
    // get a contact
    $sql = "SELECT nom, prenom FROM contact WHERE nom LIKE '" . $name . "' LIMIT 1";
    $stmt = $app['pdo']->query($sql);
    $contact = $stmt->fetch();

    return 'Hello '.$app->escape($contact['prenom'] . ' ' . $contact['nom']); 
}); 

$app->run(); 













