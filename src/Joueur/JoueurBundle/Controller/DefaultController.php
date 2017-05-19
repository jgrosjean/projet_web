<?php

namespace Joueur\JoueurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormBuilderInterface;
use Admin\AdminBundle\Entity\Licence;
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

    public function licencesInfosAction(Request $request, Licence $licence)
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
          $licencejoueur->setDepotSiCertifAncien(false);
          $licencejoueur->setAnneeLicence(2017);
          $licencejoueur->setValidationDocuments(false);
          $licencejoueur->setValidationPaiement(false);
          $licencejoueur->setDemandeLicenceEnCours(false);
          $licencejoueur->setCommentaireLicence('');

          if($licencejoueur->getNumRenouvellementLicence() == null ){
              $licencejoueur->setNumRenouvellementLicence(0);
          }
          $em->persist($licencejoueur);
          $em->flush();

          // On redirige vers la page de visualisation de l'annonce nouvellement créée
          return $this->redirect($this->generateUrl('joueur_homepage'));
            }

        return $this->render('JoueurBundle:Default:licencesInfos.html.twig', array(
          'form' => $form->createView(),
          'licence' => $licence,
             ));
     
    }

    public function documentsAction()
    {
         $em = $this->getDoctrine()->getEntityManager();
         $fichiersPresents = $em->getRepository('JoueurBundle:fichierUploadJoueur')->findBy( array('IdJoueur' => $this->getUser() ));
        return $this->render('JoueurBundle:Default:documents.html.twig', array(
        'fichiersPresents' => $fichiersPresents,
            ));
    }
    
    public function uploadFileAction()
    {
        
        $document = new fichierUploadJoueur();
        $document -> setDate(new \DateTime('now'));
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
