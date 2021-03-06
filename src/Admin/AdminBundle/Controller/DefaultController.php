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
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;



class DefaultController extends Controller
{
    public function indexAction()
    {
         $em = $this->getDoctrine()->getEntityManager();
         $licence = $em->getRepository('JoueurBundle:licenceJoueur')->findBy( array('validationLicenceFede' =>  1, 'anneeLicence' => 2017 ) );
         $licenceToutes = $em->getRepository('JoueurBundle:licenceJoueur')->findBy( array( 'anneeLicence' => 2017 ) );

         $nbrJoueursLicencie = COUNT($licence);
         $nbrJoueursEnCours = COUNT($licenceToutes) - $nbrJoueursLicencie;

        return $this->render('AdminBundle:Default:index.html.twig',array('nbrJoueursLicencie' => $nbrJoueursLicencie,
                                                                         'nbrJoueursEnCours' => $nbrJoueursEnCours,
                                                                                        ));
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
            WHERE j.id = l.idJoueur and l.anneeLicence = 2017 and l.demandeDeLicence = 1 and l.validationLicenceFede != 1'
        );
        $joueursLicencie = $query->getResult();
        $nbrJoueursLicencie = COUNT($joueursLicencie);

        $query1 = $em->createQuery(
            'SELECT j
            FROM AppBundle:User j, JoueurBundle:licenceJoueur l
            WHERE j.id = l.idJoueur and l.validationPaiement = 0 and l.anneeLicence = 2017 and l.demandeLicenceEnCours = 1'
        );

        $joueursPaiement = $query1->getResult();  
        $nbrJoueursPaiement = COUNT($joueursPaiement);

        $query3 = $em->createQuery(
            'SELECT j
            FROM AppBundle:User j, JoueurBundle:licenceJoueur l
            WHERE j.id = l.idJoueur and l.validationDocuments = 0 and l.anneeLicence = 2017 and l.demandeLicenceEnCours = 1'
        );

        $joueursDocuement = $query3->getResult();
        $nbrJoueursDocuement = COUNT($joueursDocuement);


        $query5 = $em->createQuery(
            'SELECT j
            FROM AppBundle:User j, JoueurBundle:licenceJoueur l
            WHERE j.id = l.idJoueur and l.validationDocuments = 1 and l.validationPaiement = 1 and l.anneeLicence = 2017 and l.demandeDeLicence = 0'
        );

        $joueursAttente = $query5->getResult();
        $nbrJoueursAttente = COUNT($joueursAttente);
        

        return $this->render('AdminBundle:Default:joueurs.html.twig', array(
        'joueursLicencie' => $joueursLicencie,
        'joueursDocuement' => $joueursDocuement,
        'joueursPaiement' => $joueursPaiement,
        'joueursAttente' => $joueursAttente,
        'nbrJoueursLicencie' => $nbrJoueursLicencie,
        'nbrJoueursPaiement' => $nbrJoueursPaiement,
        'nbrJoueursDocuement' => $nbrJoueursDocuement,
        'nbrJoueursAttente' => $nbrJoueursAttente,
            ));
    }

     public function joueursInfoAction(Request $request, User $user)
    {
        

        $em = $this->getDoctrine()->getEntityManager();
            $licence = $em->getRepository('JoueurBundle:licenceJoueur')->findOneBy( array('idJoueur' =>  $user->getId(), 'anneeLicence' => 2017 ) );
             $fichiersPresents = $em->getRepository('JoueurBundle:fichierUploadJoueur')->findBy( array('IdJoueur' => $user->getId() ));
        
        $licenceAdmin = $em->getRepository('AdminBundle:Licence')->findOneBy( array('id' => $licence->getIdLicenceChoisie()) );
        $fichiersPresents = $em->getRepository('JoueurBundle:fichierUploadJoueur')->findBy( array('IdJoueur' => $user->getId(), 'anneeInscription' => 2017 ));
        $majeur = $user -> estMajeur();
        $licenceReduction = $em->getRepository('AdminBundle:Licence')->findOneBy( array('id' => $licence->getIdLicenceChoisie() ));
        $verifDemandeDeLicence = false;

        if($licence->getDemandeDeLicence() == 1)
        {
            $verifDemandeDeLicence = 1;
        }

         $form = $this->get('form.factory')->create(new etatInscriptionType, $licence);

        if ($form->handleRequest($request)->isValid()) {
          $em = $this->getDoctrine()->getManager();
          if($verifDemandeDeLicence ==1 )
          {
              $licence->setDemandeDeLicence(1);
          }
          $em->persist($licence);
          $em->flush();
        
          
          // On redirige vers la page de visualisation de l'annonce nouvellement créée
          return $this->render('AdminBundle:Default:joueursInfo.html.twig', array(
        'user' => $user,
        'licence' => $licence,
        'licenceAdmin' => $licenceAdmin,
        'fichiersPresents' => $fichiersPresents,
        'licenceReduction' => $licenceReduction,
        'majeur' => $majeur,
        'form' => $form->createView(),
            ));

            }

        return $this->render('AdminBundle:Default:joueursInfo.html.twig', array(
        'user' => $user,
        'licence' => $licence,
        'licenceAdmin' => $licenceAdmin,
        'fichiersPresents' => $fichiersPresents,
        'licenceReduction' => $licenceReduction,
        'majeur' => $majeur,
        'form' => $form->createView(),
            ));
    }

    public function licenceInfoAction(Licence $licence )
    {
        $form = $this->get('form.factory')->create(new LicenceType, $licence);
         $em = $this->getDoctrine()->getEntityManager();

         $query = $em->createQuery(
            'SELECT j
            FROM AppBundle:User j, JoueurBundle:licenceJoueur l
            WHERE j.id = l.idJoueur and l.anneeLicence = 2017 and l.validationLicenceFede = 1 and l.idLicenceChoisie =  :id'
        )->setParameter('id', $licence->getId());

        $joueursInscris = $query->getResult();

        $nbrJoueur = COUNT($joueursInscris);

        return $this->render('AdminBundle:Default:licenceInfo.html.twig', array(
        'licence' => $licence,
        'nbrJoueur' => $nbrJoueur,
        'joueursInscris' => $joueursInscris,
            ));
    }

    public function recupLicencieCSVAction()
    {
        
        $response = new StreamedResponse();
        $response->setCallback(function() {
        $handle = fopen('php://output', 'w+');

        // Add the header of the CSV file  ->format('d-m-Y')  new \DateTime('now')
        $dateNow = new \DateTime('now');
        $dateStringNow= $dateNow->format('d-m-Y');
        fputcsv($handle, array('Tous les licencié au', $dateStringNow),';');
         fputcsv($handle, array(''),';');
        fputcsv($handle, array('Name', 'Prénom','date De Naissance', 'Email', 'Civilté', 'adresse', 'code postal', 'Personne à contacter', 'numéro personne à contacter'),';');


        // Query data from database
        $em = $this->getDoctrine()->getManager();
        $query4 = $em->createQuery(
            'SELECT j
            FROM AppBundle:User j, JoueurBundle:licenceJoueur l
            WHERE j.id = l.idJoueur and l.anneeLicence = 2017 and l.validationLicenceFede = 1
            ORDER BY j.nom ASC'
        );
        $results = $query4->getResult();

       foreach ($results as $result){
           fputcsv(
               $handle,
               [$result->getNom(), $result->getPrenom(), $result->getDateNaissance()->format('d-m-Y'), $result->getEmail(),$result->getCivilite(),$result->getAdresse(),$result->getCodePostal(),$result->getPersonneAContacterUrgence(),$result->getNumeroPersonneUrgence()],
               ';'
           );
       }
       

   

        fclose($handle);
    });

  $response->setStatusCode(200);
    $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
    $response->headers->set('Content-Disposition', 'attachment; filename="export_Licencié_club.csv"');
   

    return $response;
 
      
    
    }

    /**
    * @ParamConverter("licence", options={"mapping": {"licence_id": "id"}})
    */
    public function recupLicencieParLicenceCSVAction(Licence $licence)
    {
      
        
        $response = new StreamedResponse();

        $response->setCallback(function() use ($licence){
        $handle = fopen('php://output', 'w+');


        // Add the header of the CSV file  ->format('d-m-Y')  new \DateTime('now')
        $dateNow = new \DateTime('now');
        $dateStringNow= $dateNow->format('d-m-Y');
        fputcsv($handle, array('date téléchargement :', $dateStringNow),';');
        fputcsv($handle, array('Intitulé licence :', $licence->getIntitule() ),';');
        fputcsv($handle, array('catégorie:', $licence->getCategorie() ),';');
        fputcsv($handle, array('Name', 'Prénom','date De Naissance', 'Email', 'Civilté', 'adresse', 'code postal', 'Personne à contacter', 'numéro personne à contacter'),';');


        // Query data from database
        $em = $this->getDoctrine()->getManager();
        
        $query4 = $em->createQuery(
            'SELECT j
            FROM AppBundle:User j, JoueurBundle:licenceJoueur l
            WHERE j.id = l.idJoueur and l.anneeLicence = 2017 and l.validationLicenceFede = 1 and l.idLicenceChoisie = :id
            ORDER BY j.nom ASC'
        )->setParameter('id', $licence->getId());
        $results = $query4->getResult();


        if($results == null)
        {
            fputcsv($handle, array('pas de résultat'),';');
        }
       foreach ($results as $result){
           fputcsv(
               $handle,
               [$result->getNom(), $result->getPrenom(), $result->getDateNaissance()->format('d-m-Y'), $result->getEmail(),$result->getCivilite(),$result->getAdresse(),$result->getCodePostal(),$result->getPersonneAContacterUrgence(),$result->getNumeroPersonneUrgence()],
               ';'
           );
       }
    
        fclose($handle);
    });



    $response->setStatusCode(200);
    $response->headers->set('Content-Type', 'text/csv; charset=utf-8');
    $response->headers->set('Content-Disposition', 'attachment; filename="export_Licencié_club.csv"');

    return $response;
    }
    
}
