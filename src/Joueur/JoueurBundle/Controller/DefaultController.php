<?php

namespace Joueur\JoueurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilderInterface;
use Admin\AdminBundle\Entity\Licence;
use Admin\AdminBundle\Entity\fichierUpload;
use Joueur\JoueurBundle\Entity\fichierUploadJoueur;
use Joueur\JoueurBundle\Entity\licenceJoueur;
use Joueur\JoueurBundle\Form\LicenceJoueurType;
use AppBundle\Entity\User;
use AppBundle\Form\RegistrationModifDonneePerso;


class DefaultController extends Controller
{
    public function indexAction()
    {

        return $this->render('JoueurBundle:Default:index.html.twig');
    }

    public function contactAction()
    {

        return $this->render('JoueurBundle:Default:contact.html.twig');
    }

    public function monProfilAction()
    {
        
        $em = $this->getDoctrine()->getEntityManager();
        $licence = $em->getRepository('JoueurBundle:licenceJoueur')->findOneBy( array('idJoueur' => $this->getUser()->getId(), 'anneeLicence' => 2017) );

        if ($licence != null)
        {
            $licenceAdmin = $em->getRepository('AdminBundle:Licence')->findOneBy( array('id' => $licence->getIdLicenceChoisie()) );

            return $this->render('JoueurBundle:Default:monProfil.html.twig', array(
                                'licence' => $licence,
                                'licenceAdmin' => $licenceAdmin,
                                    ));
        }
        else
        {
            return $this->render('JoueurBundle:Default:monProfilNonInscrit.html.twig', array(
                                'licence' => $licence,
                                    ));
        }
        
       

        return $this->render('JoueurBundle:Default:monProfil.html.twig', array(
        'licence' => $licence,
        'licenceAdmin' => $licenceAdmin,
            ));
    }

    public function redirection_apresLoginAction()
    {
		$authChecker = $this->container->get('security.authorization_checker');

        if ($authChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirect($this->generateUrl('admin_homepage'));
        }
        else{
             return $this->redirect($this->generateUrl('joueur_homepage'));
        }
    }

    public function licencesAction()
    {
        $em = $this->getDoctrine()->getEntityManager();
            $licencesSenior = $em->getRepository('AdminBundle:Licence')->findBy( array('categorie' =>  "adulte", 'visible' => true, 'reduction' => false  ) );
            $licencesSeniorReduc = $em->getRepository('AdminBundle:Licence')->findBy( array('categorie' =>  "adulte", 'visible' => true, 'reduction' => true  ) );
            $licencesJeune = $em->getRepository('AdminBundle:Licence')->findBy( array('categorie' =>  "jeune", 'visible' => true, 'reduction' => false  ) );
            $licencesJeuneReduc = $em->getRepository('AdminBundle:Licence')->findBy( array('categorie' =>  "jeune", 'visible' => true, 'reduction' => true  ) );
            
            
            
            return $this->render('JoueurBundle:Default:licences.html.twig',array('licencesSenior' => $licencesSenior,
                                                                                 'licencesSeniorReduc' => $licencesSeniorReduc,  
                                                                                 'licencesJeune' => $licencesJeune,
                                                                                 'licencesJeuneReduc' => $licencesJeuneReduc,
                                                                                        ));
    }

    public function licencesInfosAction(Licence $licence)
    {
       

        //On check si le joueur est déjà licencié 
        $em = $this->getDoctrine()->getEntityManager();
            $checklicence = $em->getRepository('JoueurBundle:licenceJoueur')->findBy( array('anneeLicence' => 2017, 'idJoueur' => $this->getUser()->getId()) );
            if($checklicence != null){
                return $this->render('JoueurBundle:Default:licencesInfosDejaLicencie.html.twig', array(
                    'licence' => $licence,
             ));

            }
    

        return $this->render('JoueurBundle:Default:licencesInfos.html.twig', array(
          'licence' => $licence,
             ));
     
    }

    public function inscriptionLicenceEtape1Action(Request $request, Licence $licence)
    {
         $licencejoueur = new licenceJoueur();

        //On check si le joueur est déjà licencié 
        $em = $this->getDoctrine()->getEntityManager();
            $checklicence = $em->getRepository('JoueurBundle:licenceJoueur')->findBy( array('anneeLicence' => 2017, 'idJoueur' => $this->getUser()->getId()) );
            if($checklicence != null){
                return $this->render('JoueurBundle:Default:licencesInfosDejaLicencie.html.twig', array(
                    'licence' => $licence,
             ));

            }
        $form = $this->get('form.factory')->create(new LicenceJoueurType, $licencejoueur);

        if ($form->handleRequest($request)->isValid()) {
          $em = $this->getDoctrine()->getManager();
          $licencejoueur->setIdJoueur($this->getUser()->getId());
          $licencejoueur->setValidationLicenceFede(0);
          $licencejoueur->setIdLicenceChoisie($licence->getID());
          $licencejoueur->setDateInscriptionLicence(new \DateTime('now'));
          $licencejoueur->setAnneeLicence(2017);
          $licencejoueur->setDemandeDeLicence(0);
          $licencejoueur->setValidationDocuments(false);
          $licencejoueur->setValidationPaiement(false);
          $licencejoueur->setDemandeLicenceEnCours(true);
          $licencejoueur->setCommentaireLicence('');

          if($licencejoueur->getNumRenouvellementLicence() == null ){
              $licencejoueur->setNumRenouvellementLicence(0);
          }
          $em->persist($licencejoueur);
          $em->flush();

          // On redirige vers la page de visualisation de l'annonce nouvellement créée
          return $this->redirect($this->generateUrl('joueur_documents'));
            }

        return $this->render('JoueurBundle:Default:inscriptionLicenceEtape1.html.twig', array(
          'form' => $form->createView(),
          'licence' => $licence,
             ));




        return $this->render('JoueurBundle:Default:inscriptionLicenceEtape1.html.twig');
    }

    public function inscriptionLicenceEtape2Action()
    {

        return $this->render('JoueurBundle:Default:inscriptionLicenceEtape2.html.twig');
    }

    public function documentsAction()
    {
          $em = $this->getDoctrine()->getEntityManager();
        $licence = $em->getRepository('JoueurBundle:licenceJoueur')->findOneBy( array('idJoueur' => $this->getUser()->getId()) );
        $fichiersPresents = $em->getRepository('JoueurBundle:fichierUploadJoueur')->findBy( array('IdJoueur' => $this->getUser(), 'anneeInscription' => 2017 ));
        $fichiersOfficiels = $em->getRepository('AdminBundle:fichierUpload')->findAll();
        $fichiersPresentsAvant = $em->getRepository('JoueurBundle:fichierUploadJoueur')->findBy( array('IdJoueur' => $this->getUser(), 'anneeInscription' => 2017-1));
        $fichiersPresentsAvant1 = $em->getRepository('JoueurBundle:fichierUploadJoueur')->findBy( array('IdJoueur' => $this->getUser(), 'anneeInscription' => 2017-2));
        $majeur = $this -> getUser()->estMajeur();
        if($licence != null){
            $licenceReduction = $em->getRepository('AdminBundle:Licence')->findOneBy( array('id' => $licence->getIdLicenceChoisie() ));
            
        }
        else{
            $licenceReduction=null;
        }
        $extension =0;

        $document = new fichierUploadJoueur();
        $document -> setDate(new \DateTime('now'));
        $document -> setAnneeInscription(2017);
        $document -> setIdJoueur($this->getUser()->getId());
        $form = $this->createFormBuilder($document)
            ->add('name')
            ->add('file')
            ->getForm()
        ;

        if ($this->getRequest()->getMethod() === 'POST') {
            {
                    $form->bind($this->getRequest());
                    $verif=$document->verifExtension();
                    if ($form->isValid()) {
                    $em = $this->getDoctrine()->getEntityManager();
                    if( $verif == 1 ){
                        $em->persist($document);
                        $em->flush();
                        return $this->redirect($this->generateUrl('joueur_documents'));
                    }
                    else{
                        $extension =1;
                        return $this->render('JoueurBundle:Default:documents.html.twig', array(
                        'form' => $form->createView(),
                        'licence' => $licence,
                        'fichiersPresents' => $fichiersPresents,
                        'fichiersPresentsAvant' => $fichiersPresentsAvant,
                        'fichiersPresentsAvant1' => $fichiersPresentsAvant1,
                        'fichiersOfficiels' => $fichiersOfficiels,
                        'licenceReduction' => $licenceReduction,
                        'majeur' => $majeur,
                        'extension' => $extension,
            ));
                    }
                   
                    }
            }
           
        
            }
        
        return $this->render('JoueurBundle:Default:documents.html.twig', array(
        'form' => $form->createView(),
        'licence' => $licence,
        'fichiersPresents' => $fichiersPresents,
        'fichiersPresentsAvant' => $fichiersPresentsAvant,
        'fichiersPresentsAvant1' => $fichiersPresentsAvant1,
        'fichiersOfficiels' => $fichiersOfficiels,
        'licenceReduction' => $licenceReduction,
        'majeur' => $majeur,
        'extension' => $extension,
            ));
    }
    
    public function uploadFileAction()
    {
        
        $document = new fichierUploadJoueur();
        $document -> setDate(new \DateTime('now'));
        $document -> setAnneeInscription(2017);
        $document -> setIdJoueur($this->getUser()->getId());
        $form = $this->createFormBuilder($document)
            ->add('name')
            ->add('file')
            ->getForm()
        ;

        if ($this->getRequest()->getMethod() === 'POST') {
            {
                    $form->bind($this->getRequest());
                    $verif=$document->verifExtension();
                    if ($form->isValid()) {
                    $em = $this->getDoctrine()->getEntityManager();
                    if( $verif == 1 ){
                        $em->persist($document);
                        $em->flush();
                        return $this->redirect($this->generateUrl('joueur_documents'));
                    }
                    else{
                        return $this->render('JoueurBundle:Default:uploadFileErreur.html.twig', array(
                        'form' => $form->createView(),
            ));
                    }
                   
                    }
            }
           
        
            }
        
        return $this->render('JoueurBundle:Default:uploadFile.html.twig', array(
        'form' => $form->createView(),
            ));

    }

    public function modifDonneesPersoAction(Request $request)
    {
        $form = $this->get('form.factory')->create(new RegistrationModifDonneePerso, $this->getUser());

            if ($form->handleRequest($request)->isValid()) {
              $em = $this->getDoctrine()->getManager();
              $em->persist($this->getUser());
              $em->flush();
            
              // On redirige vers la page de visualisation de l'annonce nouvellement créée
              return $this->redirect($this->generateUrl('joueur_homepage'));
                }

            return $this->render('JoueurBundle:Default:modifDonneesPerso.html.twig', array(
              'form' => $form->createView(),
                 ));
    }
    
}
