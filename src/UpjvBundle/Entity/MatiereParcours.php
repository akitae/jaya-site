<?php

namespace UpjvBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Optionnelle
 *
 * @ORM\Table(name="matiere_parcours")
 * @ORM\Entity(repositoryClass="UpjvBundle\Repository\OptionnelleRepository")
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
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->matieres = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getMatieres()
    {
        return $this->matieres;
    }

    /**
     * @param mixed $matieres
     */
    public function setMatieres($matieres)
    {
        $this->matieres = $matieres;
    }

    /**
     * @return mixed
     */
    public function getParcours()
    {
        return $this->parcours;
    }

    /**
     * @param mixed $parcours
     */
    public function setParcours($parcours)
    {
        $this->parcours = $parcours;
    }

    /**
     * @return bool
     */
    public function isOptionnel()
    {
        return $this->optionnel;
    }

    /**
     * @param bool $optionnel
     */
    public function setOptionnel($optionnel)
    {
        $this->optionnel = $optionnel;
    }
}
