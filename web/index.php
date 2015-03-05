<?php
require_once __DIR__.'/../vendor/autoload.php'; 

$app = new Silex\Application(); 
$app['debug'] = true;

require_once __DIR__.'/../src/config/pdo_config.php';

// Register twig
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__ . '/../src/Views',
));


// Main controller
$app->get('/', function() use($app) { 
    return $app['twig']->render('layout.html.twig', array(
        'nom' => 'Martin',
        'prenom' =>  'Michel'
    ));
});

// First controller: simple query
$app->get('/hello', function() use($app) { 
    // get a contact
    $sql = "SELECT nom, prenom FROM contact LIMIT 1";
    $stmt = $app['pdo']->query($sql);
    $contact = $stmt->fetch();

    return $app['twig']->render('layout.html.twig', array(
        'nom' => $contact['nom'],
        'prenom' =>  $contact['prenom'],
    ));
}); 

// Display all contacts
$app->get('/contact/list', function() use($app) { 
    // get a contact
    $sql = "SELECT id, nom, prenom FROM contact ORDER BY nom, prenom";
    $stmt = $app['pdo']->query($sql);
    
    $contacts = array();
    while($contact = $stmt->fetch()) {
        $contacts[] = array(
            'id' => $contact['id'],
            'nom' => $contact['nom'],
            'prenom' =>  $contact['prenom'],
        );
    }

    return $app['twig']->render('layout.html.twig', array(
        'contacts' => $contacts
    ));
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