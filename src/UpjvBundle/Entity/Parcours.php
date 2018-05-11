<?php

namespace UpjvBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Parcours
 *
 * @ORM\Table(name="parcours")
 * @ORM\Entity(repositoryClass="UpjvBundle\Repository\ParcoursRepository")
 */
class Parcours
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var int
     *
     * @ORM\Column(name="annee", type="integer")
     */
    private $annee;

    /**
     * @ORM\JoinTable(name="semestre_parcours")
     * @ORM\ManyToMany(targetEntity="UpjvBundle\Entity\Semestre", cascade={"persist"}, inversedBy="parcours")
     */
    private $semestres;

    /**
     * @var boolean
     *
     * @ORM\Column(name="stagiare", type="boolean")
     */
    private $stagiare = false;

    /**
     * @ORM\OneToMany(targetEntity="UpjvBundle\Entity\MatiereParcours", mappedBy="parcours")
     */
    private $matieres;

    private $matiereOptionnelle;

    /**
     * @ORM\OneToMany(targetEntity="UpjvBundle\Entity\Utilisateur",mappedBy="parcours")
     */
    private $utilisateur;

    /**
     *
     * @ORM\OneToMany(targetEntity="UpjvBundle\Entity\PoleDeCompetenceParcours", mappedBy="poleDeCompetence")
     */
    private $polesDeCompetence;

    public function __construct()
    {
        $this->semestres =  new \Doctrine\Common\Collections\ArrayCollection();
        $this->matieres =  new \Doctrine\Common\Collections\ArrayCollection();
        $this->polesDeCompetence =  new \Doctrine\Common\Collections\ArrayCollection();
        $this->utilisateur =  new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set code.
     *
     * @param string $code
     *
     * @return Parcours
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set nom.
     *
     * @param string $nom
     *
     * @return Parcours
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom.
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set annee.
     *
     * @param int $annee
     *
     * @return Parcours
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Get annee.
     *
     * @return int
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    public function __toString() {

      return $this->nom;

    }
    
    /**
     * @return mixed
     */
    public function getMatiereOptionnelle()
    {
        return $this->matiereOptionnelle;
    }

    /**
     * @param mixed $matiereOptionnelle
     */
    public function setMatiereOptionnelle($matiereOptionnelle)
    {
        $this->matiereOptionnelle = $matiereOptionnelle;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPolesDeCompetence()
    {
        return $this->polesDeCompetence;
    }

    /**
     * @param mixed $polesDeCompetence
     */
    public function setPolesDeCompetence($polesDeCompetence)
    {
        $this->polesDeCompetence = $polesDeCompetence;
    }

    /**
     * @return bool
     */
    public function isStagiare()
    {
        return $this->stagiare;
    }

    /**
     * @param bool $stagiare
     */
    public function setStagiare($stagiare)
    {
        $this->stagiare = $stagiare;
    }


    /**
     * Get stagiare.
     *
     * @return bool
     */
    public function getStagiare()
    {
        return $this->stagiare;
    }

    /**
     * Add semestre.
     *
     * @param \UpjvBundle\Entity\Semestre $semestre
     *
     * @return Parcours
     */
    public function addSemestre(\UpjvBundle\Entity\Semestre $semestre)
    {
        $this->semestres[] = $semestre;

        return $this;
    }

    /**
     * Remove semestre.
     *
     * @param \UpjvBundle\Entity\Semestre $semestre
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeSemestre(\UpjvBundle\Entity\Semestre $semestre)
    {
        return $this->semestres->removeElement($semestre);
    }

    /**
     * Get semestres.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSemestres()
    {
        return $this->semestres;
    }

    /**
     * Add matiere.
     *
     * @param \UpjvBundle\Entity\MatiereParcours $matiere
     *
     * @return Parcours
     */
    public function addMatiere(\UpjvBundle\Entity\MatiereParcours $matiere)
    {
        $this->matieres[] = $matiere;

        return $this;
    }

    /**
     * Remove matiere.
     *
     * @param \UpjvBundle\Entity\MatiereParcours $matiere
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeMatiere(\UpjvBundle\Entity\MatiereParcours $matiere)
    {
        return $this->matieres->removeElement($matiere);
    }

    /**
     * Get matieres.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMatieres()
    {
        return $this->matieres;
    }

    /**
     * Add polesDeCompetence.
     *
     * @param \UpjvBundle\Entity\PoleDeCompetenceParcours $polesDeCompetence
     *
     * @return Parcours
     */
    public function addPolesDeCompetence(\UpjvBundle\Entity\PoleDeCompetenceParcours $polesDeCompetence)
    {
        $this->polesDeCompetence[] = $polesDeCompetence;

        return $this;
    }

    /**
     * Remove polesDeCompetence.
     *
     * @param \UpjvBundle\Entity\PoleDeCompetenceParcours $polesDeCompetence
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removePolesDeCompetence(\UpjvBundle\Entity\PoleDeCompetenceParcours $polesDeCompetence)
    {
        return $this->polesDeCompetence->removeElement($polesDeCompetence);
    }

    /**
     * Add utilisateur.
     *
     * @param \UpjvBundle\Entity\Utilisateur $utilisateur
     *
     * @return Parcours
     */
    public function addUtilisateur(\UpjvBundle\Entity\Utilisateur $utilisateur)
    {
        $this->utilisateur[] = $utilisateur;

        return $this;
    }

    /**
     * Remove utilisateur.
     *
     * @param \UpjvBundle\Entity\Utilisateur $utilisateur
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeUtilisateur(\UpjvBundle\Entity\Utilisateur $utilisateur)
    {
        return $this->utilisateur->removeElement($utilisateur);
    }

    /**
     * Get utilisateur.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }
}
