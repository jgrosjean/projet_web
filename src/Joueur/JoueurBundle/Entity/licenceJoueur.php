<?php

namespace Joueur\JoueurBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * licenceJoueur
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Joueur\JoueurBundle\Entity\licenceJoueurRepository")
 */
class licenceJoueur
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="renouvellementLicence", type="boolean")
     */
    private $renouvellementLicence;

    /**
     * @var integer
     *
     * @ORM\Column(name="numRenouvellementLicence", type="integer")
     */
    private $numRenouvellementLicence;

    /**
     * @var boolean
     *
     * @ORM\Column(name="donneesPubliques", type="boolean")
     */
    private $donneesPubliques;

    /**
     * @var boolean
     *
     * @ORM\Column(name="prospectionFede", type="boolean")
     */
    private $prospectionFede;

    /**
     * @var boolean
     *
     * @ORM\Column(name="prospectionTiers", type="boolean")
     */
    private $prospectionTiers;

    /**
     * @var boolean
     *
     * @ORM\Column(name="AInfoAssurance", type="boolean")
     */
    private $aInfoAssurance;

    /**
     * @var boolean
     *
     * @ORM\Column(name="declareConnaissanceModaAssurance", type="boolean")
     */
    private $declareConnaissanceModaAssurance;

    /**
     * @var boolean
     *
     * @ORM\Column(name="InfoCommuniqueFede", type="boolean")
     */
    private $infoCommuniqueFede;

    /**
     * @var integer
     *
     * @ORM\Column(name="IdJoueur", type="integer")
     */
    private $idJoueur;

    /**
     * @var integer
     *
     * @ORM\Column(name="validationLicenceFede", type="integer")
     */
    private $validationLicenceFede;

    /**
     * @var boolean
     *
     * @ORM\Column(name="depotCertifValide", type="boolean")
     */
    private $depotCertifValide;

    /**
     * @var boolean
     *
     * @ORM\Column(name="depotSiCertifAncien", type="boolean")
     */
    private $depotSiCertifAncien;

    /**
     * @var integer
     *
     * @ORM\Column(name="anneeLicence", type="integer")
     */
    private $anneeLicence;

    /**
     * @var boolean
     *
     * @ORM\Column(name="validationDocuments", type="boolean")
     */
    private $validationDocuments;

    /**
     * @var boolean
     *
     * @ORM\Column(name="validationPaiement", type="boolean")
     */
    private $validationPaiement;

    /**
     * @var boolean
     *
     * @ORM\Column(name="demandeLicenceEnCours", type="boolean")
     */
    private $demandeLicenceEnCours;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaireLicence", type="text")
     */
    private $commentaireLicence;


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
     * Set renouvellementLicence
     *
     * @param boolean $renouvellementLicence
     * @return licenceJoueur
     */
    public function setRenouvellementLicence($renouvellementLicence)
    {
        $this->renouvellementLicence = $renouvellementLicence;

        return $this;
    }

    /**
     * Get renouvellementLicence
     *
     * @return boolean 
     */
    public function getRenouvellementLicence()
    {
        return $this->renouvellementLicence;
    }

    /**
     * Set numRenouvellementLicence
     *
     * @param integer $numRenouvellementLicence
     * @return licenceJoueur
     */
    public function setNumRenouvellementLicence($numRenouvellementLicence)
    {
        $this->numRenouvellementLicence = $numRenouvellementLicence;

        return $this;
    }

    /**
     * Get numRenouvellementLicence
     *
     * @return integer 
     */
    public function getNumRenouvellementLicence()
    {
        return $this->numRenouvellementLicence;
    }

    /**
     * Set donneesPubliques
     *
     * @param boolean $donneesPubliques
     * @return licenceJoueur
     */
    public function setDonneesPubliques($donneesPubliques)
    {
        $this->donneesPubliques = $donneesPubliques;

        return $this;
    }

    /**
     * Get donneesPubliques
     *
     * @return boolean 
     */
    public function getDonneesPubliques()
    {
        return $this->donneesPubliques;
    }

    /**
     * Set prospectionFede
     *
     * @param boolean $prospectionFede
     * @return licenceJoueur
     */
    public function setProspectionFede($prospectionFede)
    {
        $this->prospectionFede = $prospectionFede;

        return $this;
    }

    /**
     * Get prospectionFede
     *
     * @return boolean 
     */
    public function getProspectionFede()
    {
        return $this->prospectionFede;
    }

    /**
     * Set prospectionTiers
     *
     * @param boolean $prospectionTiers
     * @return licenceJoueur
     */
    public function setProspectionTiers($prospectionTiers)
    {
        $this->prospectionTiers = $prospectionTiers;

        return $this;
    }

    /**
     * Get prospectionTiers
     *
     * @return boolean 
     */
    public function getProspectionTiers()
    {
        return $this->prospectionTiers;
    }

    /**
     * Set aInfoAssurance
     *
     * @param boolean $aInfoAssurance
     * @return licenceJoueur
     */
    public function setAInfoAssurance($aInfoAssurance)
    {
        $this->aInfoAssurance = $aInfoAssurance;

        return $this;
    }

    /**
     * Get aInfoAssurance
     *
     * @return boolean 
     */
    public function getAInfoAssurance()
    {
        return $this->aInfoAssurance;
    }

    /**
     * Set declareConnaissanceModaAssurance
     *
     * @param boolean $declareConnaissanceModaAssurance
     * @return licenceJoueur
     */
    public function setDeclareConnaissanceModaAssurance($declareConnaissanceModaAssurance)
    {
        $this->declareConnaissanceModaAssurance = $declareConnaissanceModaAssurance;

        return $this;
    }

    /**
     * Get declareConnaissanceModaAssurance
     *
     * @return boolean 
     */
    public function getDeclareConnaissanceModaAssurance()
    {
        return $this->declareConnaissanceModaAssurance;
    }

    /**
     * Set infoCommuniqueFede
     *
     * @param boolean $infoCommuniqueFede
     * @return licenceJoueur
     */
    public function setInfoCommuniqueFede($infoCommuniqueFede)
    {
        $this->infoCommuniqueFede = $infoCommuniqueFede;

        return $this;
    }

    /**
     * Get infoCommuniqueFede
     *
     * @return boolean 
     */
    public function getInfoCommuniqueFede()
    {
        return $this->infoCommuniqueFede;
    }

    /**
     * Set idJoueur
     *
     * @param integer $idJoueur
     * @return licenceJoueur
     */
    public function setIdJoueur($idJoueur)
    {
        $this->idJoueur = $idJoueur;

        return $this;
    }

    /**
     * Get idJoueur
     *
     * @return integer 
     */
    public function getIdJoueur()
    {
        return $this->idJoueur;
    }

    /**
     * Set validationLicenceFede
     *
     * @param integer $validationLicenceFede
     * @return licenceJoueur
     */
    public function setValidationLicenceFede($validationLicenceFede)
    {
        $this->validationLicenceFede = $validationLicenceFede;

        return $this;
    }

    /**
     * Get validationLicenceFede
     *
     * @return integer 
     */
    public function getValidationLicenceFede()
    {
        return $this->validationLicenceFede;
    }

    /**
     * Set depotCertifValide
     *
     * @param boolean $depotCertifValide
     * @return licenceJoueur
     */
    public function setDepotCertifValide($depotCertifValide)
    {
        $this->depotCertifValide = $depotCertifValide;

        return $this;
    }

    /**
     * Get depotCertifValide
     *
     * @return boolean 
     */
    public function getDepotCertifValide()
    {
        return $this->depotCertifValide;
    }

    /**
     * Set depotSiCertifAncien
     *
     * @param boolean $depotSiCertifAncien
     * @return licenceJoueur
     */
    public function setDepotSiCertifAncien($depotSiCertifAncien)
    {
        $this->depotSiCertifAncien = $depotSiCertifAncien;

        return $this;
    }

    /**
     * Get depotSiCertifAncien
     *
     * @return boolean 
     */
    public function getDepotSiCertifAncien()
    {
        return $this->depotSiCertifAncien;
    }

    /**
     * Set anneeLicence
     *
     * @param integer $anneeLicence
     * @return licenceJoueur
     */
    public function setAnneeLicence($anneeLicence)
    {
        $this->anneeLicence = $anneeLicence;

        return $this;
    }

    /**
     * Get anneeLicence
     *
     * @return integer 
     */
    public function getAnneeLicence()
    {
        return $this->anneeLicence;
    }

    /**
     * Set validationDocuments
     *
     * @param boolean $validationDocuments
     * @return licenceJoueur
     */
    public function setValidationDocuments($validationDocuments)
    {
        $this->validationDocuments = $validationDocuments;

        return $this;
    }

    /**
     * Get validationDocuments
     *
     * @return boolean 
     */
    public function getValidationDocuments()
    {
        return $this->validationDocuments;
    }

    /**
     * Set validationPaiement
     *
     * @param boolean $validationPaiement
     * @return licenceJoueur
     */
    public function setValidationPaiement($validationPaiement)
    {
        $this->validationPaiement = $validationPaiement;

        return $this;
    }

    /**
     * Get validationPaiement
     *
     * @return boolean 
     */
    public function getValidationPaiement()
    {
        return $this->validationPaiement;
    }

    /**
     * Set demandeLicenceEnCours
     *
     * @param boolean $demandeLicenceEnCours
     * @return licenceJoueur
     */
    public function setDemandeLicenceEnCours($demandeLicenceEnCours)
    {
        $this->demandeLicenceEnCours = $demandeLicenceEnCours;

        return $this;
    }

    /**
     * Get demandeLicenceEnCours
     *
     * @return boolean 
     */
    public function getDemandeLicenceEnCours()
    {
        return $this->demandeLicenceEnCours;
    }

    /**
     * Set commentaireLicence
     *
     * @param string $commentaireLicence
     * @return licenceJoueur
     */
    public function setCommentaireLicence($commentaireLicence)
    {
        $this->commentaireLicence = $commentaireLicence;

        return $this;
    }

    /**
     * Get commentaireLicence
     *
     * @return string 
     */
    public function getCommentaireLicence()
    {
        return $this->commentaireLicence;
    }
}
