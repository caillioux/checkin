<?php
require_once __DIR__.'/../vendor/autoload.php'; 

$app = new Silex\Application(); 
$app['debug'] = true;

require_once __DIR__.'/../src/config/pdo_config.php';

// First controller: simple query
$app->get('/hello/{name}', function($name) use($app) { 
    // get a contact
    $sql = "SELECT nom, prenom FROM contact LIMIT 1";
    $stmt = $app['pdo']->query($sql);
    $contact = $stmt->fetch();

    return 'Hello '.$app->escape($contact['prenom'] . ' ' . $contact['nom']); 
}); 


// Second controller: prepared query
$app->get('/anotherhello/{name}', function($name) use($app) { 
    // get a contact
    $nb_contacts = 2;
    $sql = "SELECT nom, prenom FROM contact LIMIT :nb_contacts";
    $stmt = $app['pdo']->prepare($sql);
    $stmt->bindParam(':nb_contacts', $nb_contacts, PDO::PARAM_INT);
    $stmt->execute();
    $contact = $stmt->fetch();

    return 'Hello '.$app->escape($contact['prenom'] . ' ' . $contact['nom']); 
}); 


$app->run(); 
