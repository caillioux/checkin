<?php
require_once __DIR__.'/../vendor/autoload.php'; 

use Symfony\Component\HttpFoundation\Request;

$app = new Silex\Application();
$app['debug'] = true;
$app['config'] = [
    'limit' => 20
];

// Load database connexion configuration
require_once __DIR__.'/../src/config/pdo_config.php';
require_once __DIR__.'/../src/config/twig_config.php';
require_once __DIR__.'/../src/config/app_config.php';
require_once __DIR__.'/../src/config/form_config.php';
require_once __DIR__.'/../src/config/validation_config.php';
require_once __DIR__.'/../src/config/forms.php';

// Homepage controller
$app->get('/', function() use($app) { 
}); 



// First controller: simple query
$app->get('/hello', function() use($app) { 
    // get a contact
    $sql = "SELECT lastname, firstname FROM contact LIMIT 1";
    $stmt = $app['pdo']->query($sql);
    $contact = $stmt->fetch();

    return $app['twig']->render('layout.html.twig', array(
        'firstname' => $contact['firstname'],
        'lastname' =>  $contact['lastname'],
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
$app->run(); 
