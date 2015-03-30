<?php
use Symfony\Component\Validator\Constraints as Assert;

// Contact form
$app['form_contact'] = $app->share(function() use ($app) {
    return $app['form.factory']->createBuilder('form')
        ->add('firstname', 'text', array(
            'constraints' => array(
                new Assert\NotBlank(), 
            )
        ))
        ->add('lastname', 'text', array(
            'constraints' => array(
                new Assert\NotBlank(), 
            )
        ))
        ->add('email', 'text', array(
            'constraints' => array( 
                new Assert\NotBlank(), 
                new Assert\Email(),
            )
        ))
        ->add('gender', 'choice', array(
            'choices' => array('f' => 'Madame', 'm' => 'Monsieur'),
            'expanded' => true,
            'multiple' => false,
            'constraints' => new Assert\Choice(array('f', 'm')),
        ))
        ->getForm();  
});
