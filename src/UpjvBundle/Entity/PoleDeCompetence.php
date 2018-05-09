<?php

namespace UpjvBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PoleDeCompetence
 *
 * @ORM\Table(name="pole_de_competence")
 * @ORM\Entity(repositoryClass="UpjvBundle\Repository\PoleDeCompetenceRepository")
 */
class PoleDeCompetence
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\OneToMany(targetEntity="UpjvBundle\Entity\Matiere", mappedBy="poleDeCompetence")
     */
    private $matieres;

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
     * Set nom.
     *
     * @param string $nom
     *
     * @return PoleDeCompetence
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
     * Constructor
     */
    public function __construct()
    {
        $this->parcours = new \Doctrine\Common\Collections\ArrayCollection();
        $this->matieres = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add parcour.
     *
     * @param \UpjvBundle\Entity\Parcours $parcour
     *
     * @return PoleDeCompetence
     */
    public function addParcour(\UpjvBundle\Entity\Parcours $parcour)
    {
        $this->parcours[] = $parcour;

        return $this;
    }

    /**
     * Remove parcour.
     *
     * @param \UpjvBundle\Entity\Parcours $parcour
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeParcour(\UpjvBundle\Entity\Parcours $parcour)
    {
        return $this->parcours->removeElement($parcour);
    }

    public function __toString() {

      return $this->nom;

    }

    /**
     * Add matiere.
     *
     * @param \UpjvBundle\Entity\Matiere $matiere
     *
     * @return PoleDeCompetence
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
}
