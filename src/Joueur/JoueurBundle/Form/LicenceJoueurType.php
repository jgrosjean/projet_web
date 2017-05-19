<?php

namespace Joueur\JoueurBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class LicenceJoueurType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder
         
          ->add('renouvellementLicence', 'checkbox', array(    'label'    => 'Est ce un renouvellement de licence ?',    'required' => false,))
          ->add('numRenouvellementLicence', 'integer', array(    'label'    => 'Si oui, quelle est votre numero de licence ?',    'required' => false,))
          ->add('donneesPubliques', 'checkbox', array(    'label'    => 'j accepte que mes résultats sportifs soient diffusés',    'required' => false,))
          ->add('prospectionFede', 'checkbox', array(    'label'    => 'Je souhaite recevoir les informations de la FFBaD',    'required' => false,))
          ->add('prospectionTiers', 'checkbox', array(    'label'    => 'Je souhaite recevoir des informations des partenaires de la FFBaD',    'required' => false,))
          ->add('aInfoAssurance', 'checkbox', array(    'label'    => 'J’atteste avoir été informé de l’intérêt que présente la souscription d’un contrat d’assurance de personne couvrant les dommages corporels auxquels la pratique sportive peut m’exposer (art. L321-4 du code du sport)*',    'required' => true,))
          ->add('declareConnaissanceModaAssurance', 'checkbox', array(    'label'    => 'Je déclare avoir lu, pris en connaissance et compris les modalités d’assurances présentées dans la notice d’information Assurance FFBaD ci-dessus, et de la possibilité de souscrire à l’une des garanties d’assurance Accident Corporel facultatives proposées avec ma licence.* ',    'required' => true,))
          ->add('depotCertifValide', 'checkbox', array(    'label'    => 'Le certificat médical de la fédération de badminton est daté de moins de 3 mois.',    'required' => false,))
          ->add('infoCommuniqueFede', 'checkbox', array(    'label'    => 'J’accepte que les informations ci-dessus, relatives au formulaire de licence, soient communiquées à la FFBaD*',    'required' => true,))


          ->add('Envoyer',        'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Joueur\JoueurBundle\Entity\LicenceJoueur'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'joueur_joueurbundle_licencesinfos';
    }
}