<?php

namespace UpjvBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MatiereProfesseur
 *
 * @ORM\Table(name="matiere_professeur")
 * @ORM\Entity(repositoryClass="UpjvBundle\Repository\MatiereProfesseurRepository")
 */
class MatiereProfesseur
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
     * @ORM\ManyToMany(targetEntity="UpjvBundle\Entity\Utilisateur", cascade={"persist"})
     */
    private $utilisateurs;

    /**
     * @ORM\ManyToMany(targetEntity="UpjvBundle\Entity\Matiere", cascade={"persist"})
     */
    private $matieres;

    /**
     * @var int
     *
     * @ORM\Column(name="nbHeuresTP", type="integer")
     */
    private $nbHeuresTP;

    /**
     * @var int
     *
     * @ORM\Column(name="nbHeuresTD", type="integer")
     */
    private $nbHeuresTD;

    /**
     * @var int
     *
     * @ORM\Column(name="nbHeureCours", type="integer")
     */
    private $nbHeureCours;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->utilisateurs = new \Doctrine\Common\Collections\ArrayCollection();
        $this->matieres = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set nbHeuresTP.
     *
     * @param int $nbHeuresTP
     *
     * @return MatiereProfesseur
     */
    public function setNbHeuresTP($nbHeuresTP)
    {
        $this->nbHeuresTP = $nbHeuresTP;

        return $this;
    }

    /**
     * Get nbHeuresTP.
     *
     * @return int
     */
    public function getNbHeuresTP()
    {
        return $this->nbHeuresTP;
    }

    /**
     * Set nbHeuresTD.
     *
     * @param int $nbHeuresTD
     *
     * @return MatiereProfesseur
     */
    public function setNbHeuresTD($nbHeuresTD)
    {
        $this->nbHeuresTD = $nbHeuresTD;

        return $this;
    }

    /**
     * Get nbHeuresTD.
     *
     * @return int
     */
    public function getNbHeuresTD()
    {
        return $this->nbHeuresTD;
    }

    /**
     * Set nbHeureCours.
     *
     * @param int $nbHeureCours
     *
     * @return MatiereProfesseur
     */
    public function setNbHeureCours($nbHeureCours)
    {
        $this->nbHeureCours = $nbHeureCours;

        return $this;
    }

    /**
     * Get nbHeureCours.
     *
     * @return int
     */
    public function getNbHeureCours()
    {
        return $this->nbHeureCours;
    }

    /**
     * Add utilisateur.
     *
     * @param \UpjvBundle\Entity\Utilisateur $utilisateur
     *
     * @return MatiereProfesseur
     */
    public function addUtilisateur(\UpjvBundle\Entity\Utilisateur $utilisateur)
    {
        $this->utilisateurs[] = $utilisateur;

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
        return $this->utilisateurs->removeElement($utilisateur);
    }

    /**
     * Get utilisateurs.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUtilisateurs()
    {
        return $this->utilisateurs;
    }

    /**
     * Add matiere.
     *
     * @param \UpjvBundle\Entity\Matiere $matiere
     *
     * @return MatiereProfesseur
     */
    public function addMatiere(\UpjvBundle\Entity\Matiere $matiere)
    {
        $this->matieres[] = $matiere;

        return $this;
    }

    /**
     * Remove matiere.
     *
     * @param \UpjvBundle\Entity\Matiere $matiere
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeMatiere(\UpjvBundle\Entity\Matiere $matiere)
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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
}
