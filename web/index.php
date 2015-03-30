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
    return $app['twig']->render('test.html.twig', array(
    ));
}); 

// Contacts controller
$app->get('/contacts', function() use($app) {
    // get a contact
    $sql = "SELECT id, gender, lastname, firstname, birthday FROM contact ORDER BY id DESC";
    $stmt = $app['pdo']->query($sql);
    
    $contacts = array();
    while($contact = $stmt->fetch()) {
        $contacts[] = array(
            'id' => $contact['id'],
            'gender' =>  $contact['gender'],
            'lastname' => $contact['lastname'],
            'firstname' =>  $contact['firstname'],
            'birthday' =>  $contact['birthday'],
        );
    }

    
    return $app['twig']->render('contacts/list.html.twig', array(
        'contacts' => $contacts,
    ));
}); 


// Delete a contact
$app->get('/contacts/{id}/delete', function($id) use ($app) {
    $sql = 'DELETE FROM contact WHERE id=:id';

    $statement = $app['pdo']->prepare($sql);

    $statement->execute(array(':id' => $id));

    return $app->redirect($app['controller_url'] . '/contacts');
});

$app->run(); 
