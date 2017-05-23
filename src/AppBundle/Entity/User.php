<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

	  /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;


    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="personneAContacterUrgence", type="string", length=255)
     */
    private $personneAContacterUrgence;

     /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNaissance", type="date")
     */
    private $dateNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=255)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="sexe", type="string", length=255)
     */
    private $sexe;

    /**
     * @var string
     *
     * @ORM\Column(name="civilite", type="string", length=255)
     */
    private $civilite;

    /**
     * @var string
     *
     * @ORM\Column(name="nationalite", type="string", length=255)
     */
    private $nationalite;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    private $adresse;

    /**
     * @var integer
     *
     * @ORM\Column(name="codePostal", type="integer")
     */
    private $codePostal;

    /**
     * @var integer
     *
     * @ORM\Column(name="numeroPersonneUrgence", type="integer")
     */
    private $numeroPersonneUrgence;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="pays", type="string", length=255)
     */
    private $pays;


    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
    
     /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
 


      /**
     * Set nom
     *
     * @param string $nom
     * @return Humain
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set personneAContacterUrgence
     *
     * @param string $personneAContacterUrgence
     * @return Humain
     */
    public function setPersonneAContacterUrgence($personneAContacterUrgence)
    {
        $this->personneAContacterUrgence = $personneAContacterUrgence;

        return $this;
    }

    /**
     * Get personneAContacterUrgence
     *
     * @return string 
     */
    public function getPersonneAContacterUrgence()
    {
        return $this->personneAContacterUrgence;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return Humain
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }
     /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     *
     * @return donne
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }
    
     /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return allright
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }
    /**
     * Set sexe
     *
     * @param string $sexe
     * @return licence_Joueur
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string 
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set civilite
     *
     * @param string $civilite
     * @return licence_Joueur
     */
    public function setCivilite($civilite)
    {
        $this->civilite = $civilite;

        return $this;
    }

    /**
     * Get civilite
     *
     * @return string 
     */
    public function getCivilite()
    {
        return $this->civilite;
    }

    /**
     * Set nationalite
     *
     * @param string $nationalite
     * @return licence_Joueur
     */
    public function setNationalite($nationalite)
    {
        $this->nationalite = $nationalite;

        return $this;
    }

    /**
     * Get nationalite
     *
     * @return string 
     */
    public function getNationalite()
    {
        return $this->nationalite;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     * @return licence_Joueur
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string 
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set numeroPersonneUrgence
     *
     * @param integer $numeroPersonneUrgence
     * @return licence_Joueur
     */
    public function setNumeroPersonneUrgence($numeroPersonneUrgence)
    {
        $this->numeroPersonneUrgence = $numeroPersonneUrgence;

        return $this;
    }

    /**
     * Get numeroPersonneUrgence
     *
     * @return integer 
     */
    public function getNumeroPersonneUrgence()
    {
        return $this->numeroPersonneUrgence;
    }

    /**
     * Set codePostal
     *
     * @param integer $codePostal
     * @return licence_Joueur
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal
     *
     * @return integer 
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * Set ville
     *
     * @param string $ville
     * @return licence_Joueur
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string 
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set pays
     *
     * @param string $pays
     * @return licence_Joueur
     */
    public function setPays($pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return string 
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Get estMajeur
     *
     * @return integer 
     */
    public function estMajeur()
    {
        if ((new \DateTime())->diff($this->getDateNaissance())->format('%y') < 18)
        {
            return 1 ; 
        }
        else{
            return 0;
        }


    }

}
