<?php

namespace Admin\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class etatInscriptionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
         $builder
          ->add('validationDocuments',       'checkbox', array(    'label'    => 'On a bien recu les documents',    'required' => false,))
          ->add('validationPaiement',       'checkbox', array(    'label'    => 'On a bien recu le paiement',    'required' => false,))
          ->add('depotCertifValide',       'checkbox', array(    'label'    => 'le certif medical est daté de moins de 3 mois ',    'required' => false,))


          ->add('demandeDeLicence',       'checkbox', array(    'label'    => 'demande d enregistrement la licence dans Poona ',    'required' => false,))
          ->add('commentaireLicence', 'text', array(    'label'    => 'Commentaire a afficher pour le licencié : ',    'required' => false,))

          ->add('Envoyer',        'submit')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Joueur\JoueurBundle\Entity\licenceJoueur'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'admin_adminbundle_creerlicence';
    }
}
         
          
