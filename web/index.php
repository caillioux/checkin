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

// Homepage controller
$app->get('/', function() use($app) { 
    // Story
    // Homepage allows a user to connect
    //      When I provide a 'login' and a 'password'
    //      And 'login' and 'password' match a valid user
    //      Then I should be redirected to dashboard
    //      
    //      When I provide a 'login' and a 'password'
    //      And 'login' and 'password' doesn't match a valid user
    //      Then I should stay on homepage and see message 'Impossible de se connecter'
    //      
    //      When I click on 'Mot de passe oublié ?'
    //      Then I should be redirected to '/reset-password'
}); 

// Reset password controller
$app->get('/reset-password', function() use($app) { 
    // Story
    // User can reset his password
    //      When I give my email address
    //      And my email matches a user
    //      Then I receive a mail with a link to change my password 
});

// Change password controller
$app->get('/change-password', function() use($app) { 
    // Story
    // User can click a link and change his password
    //      When I click a reset password link
    //      And the link matches a reset password request
    //      Then I can provide a new password for my account
});

// Display dashboard controller
$app->get('/dashboard', function() use($app) { 
    // Fonctionnalités
    // Afficher Bonjour M. Machin
    // Afficher un menu de navigation
    // Événements
    //      Afficher une liste limitée des événements
    //      Action "Nouvel événement"
    //      Action "Chercher un événement"
    // Contacts
    //      Afficher une liste limitée des contacts
    //      Action "Nouveau contact"
    //      Action "Chercher un contact"
    // Action "Se déconnecter"
});


// Display events controller
$app->get('/dashboard/events', function() use($app) { 
    // Fonctionnalités
    // Afficher une liste des événements
    // Action "Nouvel événement"
    // Action "Chercher un événement"
    
    // Default ordering
    $ordering = 'date_begin';

    // Default limit
    $limit = $app['config']['limit'];

    // get a event
    $sql = "SELECT ";
    $sql.= "id, name, description, address, latitude, longitude, date_begin, date_end, picture, price, url, type, phone, email, max_places, published ";
    $sql.= "FROM event ";
    $sql.= "ORDER BY $ordering ";
    $sql.= "LIMIT :limit";
    
    $eventsStatement = $app['pdo']->prepare($sql);
    $eventsStatement->bindParam(':limit', $limit, PDO::PARAM_INT);
    $eventsStatement->execute();
    
    return $app['twig']->render('events/list.html.twig', array(
        'events' => $eventsStatement->fetchAll(),
    ));

});


// Display event detail controller
$app->get('/dashboard/events/{id}', function() use($app) { 
    // Fonctionnalités
    // Afficher le détail d'un événement
});

// Delete an event  controller
$app->delete('/dashboard/events/{id}', function() use($app) { 
    // Fonctionnalités
    // Efface un événement
});

// Display new event form controller
$app->get('/dashboard/events/create', function() use($app) { 
    // Fonctionnalités
    // Affiche le formulaire vide pour un nouvel événement
});

// Create a new event controller
$app->post('/dashboard/events/create', function() use($app) { 
    // Fonctionnalités
    // Enregistre les données d'un nouvel événement
});


// New event form controller
// $app->match('/dashboard/events/create', function() use($app) { 
    // Fonctionnalités
    // Affiche le formulaire vide pour un nouvel événement
    // Enregistre les données d'un nouvel événement
// }
// });


// Display new contact form controller
$app->get('/dashboard/contacts/new', function() use($app) { 
    // Fonctionnalités
    // Affiche le formulaire vide pour un nouveau contact

    return $app['twig']->render('contacts/new.html.twig', array(
    ));
});

// Display contacts controller
$app->get('/dashboard/contacts', function() use($app) { 
    // Fonctionnalités
    // Afficher une liste des contacts
    // Action "Nouveau contact"
    // Action "Chercher un contact"

    // Default ordering
    $ordering = 'created_at';

    // Default limit
    $limit = $app['config']['limit'];

    // get a contact
    $sql = "SELECT ";
    $sql.= "id, gender, lastname, firstname, birthday, phone, email, address, zipcode, city, created_at ";
    $sql.= "FROM contact ";
    $sql.= "ORDER BY $ordering ";
    $sql.= "LIMIT :limit";
    
    $contactsStatement = $app['pdo']->prepare($sql);
    $contactsStatement->bindParam(':limit', $limit, PDO::PARAM_INT);
    $contactsStatement->execute();
    
    return $app['twig']->render('contacts/list.html.twig', array(
        'contacts' => $contactsStatement->fetchAll(),
    ));
});


// Display contact detail controller
$app->get('/dashboard/contacts/{id}', function() use($app) { 
    // Fonctionnalités
    // Afficher le détail d'un contact
});

// Delete an contact  controller
$app->delete('/dashboard/contacts/{id}', function() use($app) { 
    // Fonctionnalités
    // Efface un contact
});


// Create a new contact controller
$app->post('/dashboard/contacts/new', function(Request $request) use($app) { 
    // Fonctionnalités
    // Enregistre les données d'un nouveau contact
    
    // echo "<pre>";
    // echo "POST\n";
    // print_r($_POST);
    // echo "GET\n";
    // print_r($_GET);
    // echo "</pre>";

    echo "<pre>";
    print_r($request->request->all());
    echo "\n";
    $contact = $request->request->get('contact');
    echo $contact['firstname'];
    echo "</pre>";

    return 'formulaire reçu !';
});


// New contact form controller
// $app->match('/dashboard/contacts/create', function() use($app) { 
    // Fonctionnalités
    // Affiche le formulaire vide pour un nouveau contact
    // Enregistre les données d'un nouveau contact
// }
// });

$app->run(); 













