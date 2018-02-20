<?php

namespace UpjvBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Semestre
 *
 * @ORM\Table(name="semestre")
 * @ORM\Entity(repositoryClass="UpjvBundle\Repository\SemestreRepository")
 */
class Semestre
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
     * @var \DateTime
     *
     * @ORM\Column(name="dateDebut", type="datetime")
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFin", type="datetime")
     */
    private $dateFin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDebutChoix", type="datetime")
     */
    private $dateDebutChoix;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFinChoix", type="datetime")
     */
    private $dateFinChoix;

    /**
     * @ORM\OneToMany(targetEntity="Matiere", mappedBy="semestre")
     */
    private $matieres;

    /**
     * @ORM\ManyToMany(targetEntity="UpjvBundle\Entity\Parcours", cascade={"persist"})
     */
    private $parcours;


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
     * @return Semestre
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
     * Set dateDebut.
     *
     * @param \DateTime $dateDebut
     *
     * @return Semestre
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut.
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin.
     *
     * @param \DateTime $dateFin
     *
     * @return Semestre
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin.
     *
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * Set dateDebutChoix.
     *
     * @param \DateTime $dateDebutChoix
     *
     * @return Semestre
     */
    public function setDateDebutChoix($dateDebutChoix)
    {
        $this->dateDebutChoix = $dateDebutChoix;

        return $this;
    }

    /**
     * Get dateDebutChoix.
     *
     * @return \DateTime
     */
    public function getDateDebutChoix()
    {
        return $this->dateDebutChoix;
    }

    /**
     * Set dateFinChoix.
     *
     * @param \DateTime $dateFinChoix
     *
     * @return Semestre
     */
    public function setDateFinChoix($dateFinChoix)
    {
        $this->dateFinChoix = $dateFinChoix;

        return $this;
    }

    /**
     * Get dateFinChoix.
     *
     * @return \DateTime
     */
    public function getDateFinChoix()
    {
        return $this->dateFinChoix;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->matieres = new \Doctrine\Common\Collections\ArrayCollection();
        $this->parcours = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add matiere.
     *
     * @param \UpjvBundle\Entity\Matiere $matiere
     *
     * @return Semestre
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
     * Add parcour.
     *
     * @param \UpjvBundle\Entity\Parcours $parcour
     *
     * @return Semestre
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

    /**
     * Get parcours.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getParcours()
    {
        return $this->parcours;
    }
}
