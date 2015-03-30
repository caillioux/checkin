<?php
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;
$controller = $app['controllers_factory'];

$controller->match('/', function (Request $request) use ($app) {
    // some default data for when the form is displayed the first time
    $data = array(
        'name' => 'Your name',
        'email' => 'Your email',
    );

    $form = $app['form.factory']->createBuilder('form')
        ->add('name', 'text', array(
            'constraints' => array(
                new Assert\NotBlank(), 
                new Assert\Length(array('min' => 5))
            )
        ))
        ->add('description', 'textarea', array(
            'constraints' => array(
                new Assert\NotBlank(), 
                new Assert\Length(array('min' => 5, 'max' => 10))
            )
        ))
        ->add('email', 'text', array(
            'constraints' => new Assert\Email()
        ))
        ->add('gender', 'choice', array(
            'choices' => array(1 => 'male', 2 => 'female'),
            'expanded' => true,
            'multiple' => true,
            'constraints' => new Assert\Choice(array(1, 2)),
        ))
        ->getForm();  

    $form->handleRequest($request);

    if ($form->isValid()) {
        $data = $form->getData();
        print_r($data);
        exit;

        // do something with the data

        // redirect somewhere
        return $app->redirect('/');
    }

    // display the form
    return $app['twig']->render('form.twig.html', array('form' => $form->createView()));
});

return $controller;
