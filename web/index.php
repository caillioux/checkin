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
})->assert('id', '/\d+');

// Delete an contact  controller
$app->get('/dashboard/contacts/{id}/delete', function($id) use($app) { 

    $sql = "DELETE FROM contact WHERE id = :id";

    $statement = $app['pdo']->prepare($sql);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);

    $statement->execute();

    // renvoyer l'utilisateur vers la liste des contacts
    return $app->redirect($app['controller_url'] . '/dashboard/contacts');
});


// Display new contact form controller
$app->get('/dashboard/contacts/new', function() use($app) { 
    // return $app->redirect($app['controller_url'] . '/dashboard/contacts');
    // echo $app['controller_url'];exit;
    return $app['twig']->render('contacts/new.html.twig', array(
    ));
});

// Create a new contact controller
$app->post('/dashboard/contacts/new', function(Request $request) use($app) { 
    // récupérer les données
    $contact = $request->request->get('contact');

    $sql = "INSERT INTO contact (gender, firstname, lastname, email) VALUES (:gender, :firstname, :lastname, :email)";
    $statement = $app['pdo']->prepare($sql);
    $statement->execute($contact);

    // foreach ($contact as $field => $value) {
    //     $statement->bindParam(':' . $field, $value);
    // }
    // $statement->execute();


    // $statement->bindParam(':gender', $contact['gender']);
    // $statement->bindParam(':lastname', $contact['lastname']);
    // $statement->bindParam(':firstname', $contact['firstname']);
    // $statement->bindParam(':email', $contact['email']);

    // renvoyer l'utilisateur vers la liste des contacts
    return $app->redirect($app['controller_url'] . '/dashboard/contacts');
});


// New contact form controller
// $app->match('/dashboard/contacts/create', function() use($app) { 
    // Fonctionnalités
    // Affiche le formulaire vide pour un nouveau contact
    // Enregistre les données d'un nouveau contact
// }
// });


// Connect form controllers
$app->mount('/form', include(__DIR__ . '/../src/controllers/SampleFormController.php'));

$app->run(); 













