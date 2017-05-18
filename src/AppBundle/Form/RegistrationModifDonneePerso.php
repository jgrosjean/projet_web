<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationModifDonneePerso extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('nom')
                    ->add('prenom')
                    ->add('dateNaissance','date', array('years' => range(date('Y') -100, date('Y')),))
                    ->add('nationalite')
                    ->add('telephone')
                    ->add('sexe', 'choice', array('choices' => array(
                                                                    'Homme' => 'Homme',
                                                                    'Femme' => 'Femme',)))
                    ->add('civilite', 'choice', array('choices' => array(
                                                                    'M.' => 'M.',
                                                                    'Mme' => 'Mme',
                                                                    'Mlle' => 'Mlle',
                                                                    'Dr.' => 'Dr.',)))
                    ->add('adresse')
                    ->add('codePostal')
                    ->add('ville')
                    ->add('pays')
                    ->add('Envoyer',        'submit')
                ;
    }

    

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }
}