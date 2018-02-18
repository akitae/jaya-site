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
     * @ORM\ManyToMany(targetEntity="UpjvBundle\Entity\PoleDeCompetence", cascade={"persist"})
     */
    private $polesDeCompetences;


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

    /**
     * @return mixed
     */
    public function getPolesDeCompetences()
    {
        return $this->polesDeCompetences;
    }

    /**
     * @param mixed $polesDeCompetences
     */
    public function setPolesDeCompetences($polesDeCompetences)
    {
        $this->polesDeCompetences = $polesDeCompetences;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->polesDeCompetences = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add polesDeCompetence.
     *
     * @param \UpjvBundle\Entity\PoleDeCompetence $polesDeCompetence
     *
     * @return Parcours
     */
    public function addPolesDeCompetence(\UpjvBundle\Entity\PoleDeCompetence $polesDeCompetence)
    {
        $this->polesDeCompetences[] = $polesDeCompetence;

        return $this;
    }

    /**
     * Remove polesDeCompetence.
     *
     * @param \UpjvBundle\Entity\PoleDeCompetence $polesDeCompetence
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removePolesDeCompetence(\UpjvBundle\Entity\PoleDeCompetence $polesDeCompetence)
    {
        return $this->polesDeCompetences->removeElement($polesDeCompetence);
    }
}
