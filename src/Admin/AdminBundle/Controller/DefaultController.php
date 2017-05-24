<?php

namespace Admin\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Admin\AdminBundle\Entity\Licence;
use Joueur\JoueurBundle\Entity\licenceJoueur;
use AppBundle\Entity\User;
use Admin\AdminBundle\Entity\fichierUpload;
use Admin\AdminBundle\Form\LicenceType;
use Admin\AdminBundle\Form\CreerLicenceType;
use Admin\AdminBundle\Form\etatInscriptionType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\File\UploadedFile;



class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AdminBundle:Default:index.html.twig');
    }

    public function licencesAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
            $licencesSenior = $em->getRepository('AdminBundle:Licence')->findBy( array('categorie' =>  "adulte", 'visible' => true, 'reduction' => false  ) );
            $licencesSeniorReduc = $em->getRepository('AdminBundle:Licence')->findBy( array('categorie' =>  "adulte", 'visible' => true, 'reduction' => true  ) );
            $licencesJeune = $em->getRepository('AdminBundle:Licence')->findBy( array('categorie' =>  "jeune", 'visible' => true, 'reduction' => false  ) );
            $licencesJeuneReduc = $em->getRepository('AdminBundle:Licence')->findBy( array('categorie' =>  "jeune", 'visible' => true, 'reduction' => true  ) );
            
            
            
            return $this->render('AdminBundle:Default:licences.html.twig',array('licencesSenior' => $licencesSenior,
                                                                                 'licencesSeniorReduc' => $licencesSeniorReduc,  
                                                                                 'licencesJeune' => $licencesJeune,
                                                                                 'licencesJeuneReduc' => $licencesJeuneReduc,
                                                                                        ));
    }

    public function licencesNonVisiblesAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
            $licencesNonVisibles = $em->getRepository('AdminBundle:Licence')->findBy( array('visible' => false ) );
       
            return $this->render('AdminBundle:Default:licencesNonVisibles.html.twig',array('licencesNonVisibles' => $licencesNonVisibles,
                                                                            
                                                                                        ));
    }

    public function creerFormLicenceAction(Request $request)
    {
        $licence = new Licence();

        $form = $this->get('form.factory')->create(new CreerLicenceType, $licence);

        if ($form->handleRequest($request)->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($licence);
          $em->flush();
        
          // On redirige vers la page de visualisation de l'annonce nouvellement créée
          return $this->redirect($this->generateUrl('admin_licences'));
            }

        return $this->render('AdminBundle:Default:creerFormLicence.html.twig', array(
          'form' => $form->createView(),
             ));

    }

    
     public function modifierLicenceAction(Request $request, Licence $licence)
    {
        $form = $this->get('form.factory')->create(new LicenceType, $licence);

        if ($form->handleRequest($request)->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($licence);
          $em->flush();
        
          // On redirige vers la page de visualisation de l'annonce nouvellement créée
          return $this->redirect($this->generateUrl('admin_licences'));
            }

        return $this->render('AdminBundle:Default:modifierLicence.html.twig', array(
          'form' => $form->createView(),
          'licence' => $licence,
             ));

    }

    
   
    public function gererUploadLicenceAction()
    {
        $document = new fichierUpload();
        $form = $this->createFormBuilder($document)
            ->add('name')
            ->add('file')
            ->getForm()
        ;
        $extension =0;

         $em = $this->getDoctrine()->getEntityManager();
         $fichiersPresents = $em->getRepository('AdminBundle:fichierUpload')->findAll();

         if ($this->getRequest()->getMethod() === 'POST') {
            {
                    $form->bind($this->getRequest());
                    $verif=$document->verifExtension();
                    if ($form->isValid()) {
                    $em = $this->getDoctrine()->getEntityManager();
                    if( $verif == 1 ){
                        $em->persist($document);
                        $em->flush();
                        return $this->redirect($this->generateUrl('admin_gererUploadLicence'));
                    }
                    else{
                        $extension =1;
                        return $this->render('AdminBundle:Default:gererUploadLicence.html.twig', array(
                        'form' => $form->createView(),
                        'fichiersPresents' => $fichiersPresents,
                        'extension' => $extension,
            ));
                    }
                   
                    }
            }
        
            }




        return $this->render('AdminBundle:Default:gererUploadLicence.html.twig', array(
        'fichiersPresents' => $fichiersPresents,
        'form' => $form->createView(),
        'extension' => $extension,
            ));
    }


    public function supprimerUploadLicenceAction(fichierUpload $fichier)
    {
        return $this->render('AdminBundle:Default:supprimerUploadLicence.html.twig', array(
        'fichier' => $fichier,
            ));
    }

    public function suppressionEnCoursUploadLicenceAction(fichierUpload $fichier)
    {
        $em = $this->getDoctrine() ->getManager();
        $em->remove($fichier);
        $em->flush();

        return $this->redirect($this->generateUrl('admin_gererUploadLicence'));
    }

    public function joueursAction()
    {
        $em = $this->getDoctrine()->getManager();

        $query = $em->createQuery(
            'SELECT j
            FROM AppBundle:User j, JoueurBundle:licenceJoueur l
            WHERE j.id = l.idJoueur and l.anneeLicence = 2017 and l.demandeLicenceEnCours = 0'
        );
        $joueursLicencie = $query->getResult();

        $query1 = $em->createQuery(
            'SELECT j
            FROM AppBundle:User j, JoueurBundle:licenceJoueur l
            WHERE j.id = l.idJoueur and l.validationDocuments = 1 and l.validationPaiement = 0 and l.anneeLicence = 2017 and l.demandeLicenceEnCours = 1'
        );

        $joueursPaiement = $query1->getResult();


        $query2 = $em->createQuery(
            'SELECT j
            FROM AppBundle:User j, JoueurBundle:licenceJoueur l
            WHERE j.id = l.idJoueur and l.validationDocuments = 0 and l.validationPaiement = 0 and l.anneeLicence = 2017 and l.demandeLicenceEnCours = 1'
        );

        $joueursDocuementPaiement = $query2->getResult();

        $query3 = $em->createQuery(
            'SELECT j
            FROM AppBundle:User j, JoueurBundle:licenceJoueur l
            WHERE j.id = l.idJoueur and l.validationDocuments = 0 and l.validationPaiement = 1 and l.anneeLicence = 2017 and l.demandeLicenceEnCours = 1'
        );

        $joueursDocuement = $query3->getResult();

        return $this->render('AdminBundle:Default:joueurs.html.twig', array(
        'joueursLicencie' => $joueursLicencie,
        'joueursDocuementPaiement' => $joueursDocuementPaiement,
        'joueursDocuement' => $joueursDocuement,
        'joueursPaiement' => $joueursPaiement,
            ));
    }

     public function joueursInfoAction(User $user)
    {

        $em = $this->getDoctrine()->getEntityManager();
            $licenceActuelle = $em->getRepository('JoueurBundle:licenceJoueur')->findOneBy( array('idJoueur' =>  $user->getId(), 'anneeLicence' => 2017 ) );

        return $this->render('AdminBundle:Default:joueursInfo.html.twig', array(
        'user' => $user,
        'licenceActuelle' => $licenceActuelle,
            ));
    }

    public function licenceInfoAction(Licence $licence )
    {
        return $this->render('AdminBundle:Default:licenceInfo.html.twig', array(
        'licence' => $licence,
            ));
    }

    public function modifInscriptionJoueurAction(Request $request, licenceJoueur $licenceAModif )
    {
         $form = $this->get('form.factory')->create(new etatInscriptionType, $licenceAModif);

        if ($form->handleRequest($request)->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $em->persist($licenceAModif);
          $em->flush();
        
          // On redirige vers la page de visualisation de l'annonce nouvellement créée
          return $this->redirect($this->generateUrl('admin_licences'));
            }

        return $this->render('AdminBundle:Default:modifInscriptionJoueur.html.twig', array(
          'form' => $form->createView(),
             ));


    }
    
}
