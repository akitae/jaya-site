<?php

namespace UpjvBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Optionnelle
 *
 * @ORM\Table(name="matiere_parcours")
 * @ORM\Entity(repositoryClass="UpjvBundle\Repository\MatiereParcoursRepository")
 */
class MatiereParcours
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
     * @ORM\ManyToOne(targetEntity="UpjvBundle\Entity\Matiere", cascade={"persist"})
     */
    private $matieres;

    /**
     * @ORM\ManyToOne(targetEntity="UpjvBundle\Entity\Parcours", cascade={"persist"})
     */
    private $parcours;

    /**
     * @ORM\Column(name="optionnel", type="boolean")
     * @var bool
     */
    private $optionnel = false;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->matieres = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set optionnel.
     *
     * @param bool $optionnel
     *
     * @return MatiereParcours
     */
    public function setOptionnel($optionnel)
    {
        $this->optionnel = $optionnel;

        return $this;
    }

    /**
     * Get optionnel.
     *
     * @return bool
     */
    public function getOptionnel()
    {
        return $this->optionnel;
    }

    /**
     * Get optionnel.
     *
     * @return bool
     */
    public function isOptionnel()
    {
        return $this->optionnel;
    }

    /**
     * Set matieres.
     *
     * @param \UpjvBundle\Entity\Matiere|null $matieres
     *
     * @return MatiereParcours
     */
    public function setMatieres(\UpjvBundle\Entity\Matiere $matieres = null)
    {
        $this->matieres = $matieres;

        return $this;
    }

    /**
     * Get matieres.
     *
     * @return \UpjvBundle\Entity\Matiere|null
     */
    public function getMatieres()
    {
        return $this->matieres;
    }

    /**
     * Set parcours.
     *
     * @param \UpjvBundle\Entity\Parcours|null $parcours
     *
     * @return MatiereParcours
     */
    public function setParcours(\UpjvBundle\Entity\Parcours $parcours = null)
    {
        $this->parcours = $parcours;

        return $this;
    }

    /**
     * Get parcours.
     *
     * @return \UpjvBundle\Entity\Parcours|null
     */
    public function getParcours()
    {
        return $this->parcours;
    }
}
