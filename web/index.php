<?php
require_once __DIR__.'/../vendor/autoload.php'; 

$app = new Silex\Application();
$app['debug'] = true;
$app['config'] = [
    'limit' => 20
];

// Load database connexion configuration
require_once __DIR__.'/../src/config/pdo_config.php';
require_once __DIR__.'/../src/config/twig_config.php';

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
    
    $stmt = $app['pdo']->prepare($sql);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    
    // Create content array with all strings to display
    $content = [];
    foreach ($stmt as $contact) {
        $content[] = sprintf('#%s %s %s', $contact['id'], $contact['lastname'], $contact['firstname']);
    }

    $content = implode($content, '<br/>');
    return $app['twig']->render('layout.html.twig', array(
        'content' => $content,
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

// Display new contact form controller
$app->get('/dashboard/contacts/create', function() use($app) { 
    // Fonctionnalités
    // Affiche le formulaire vide pour un nouveau contact
});

// Create a new contact controller
$app->post('/dashboard/contacts/create', function() use($app) { 
    // Fonctionnalités
    // Enregistre les données d'un nouveau contact
});


// New contact form controller
// $app->match('/dashboard/contacts/create', function() use($app) { 
    // Fonctionnalités
    // Affiche le formulaire vide pour un nouveau contact
    // Enregistre les données d'un nouveau contact
// }
// });

$app->run(); 













