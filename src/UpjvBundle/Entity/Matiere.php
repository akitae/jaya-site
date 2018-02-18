<?php

namespace UpjvBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Matiere
 *
 * @ORM\Table(name="matiere")
 * @ORM\Entity(repositoryClass="UpjvBundle\Repository\MatiereRepository")
 */
class Matiere
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
     * @ORM\Column(name="place", type="integer")
     */
    private $place;

    /**
     * @ORM\ManyToMany(targetEntity="UpjvBundle\Entity\PoleDeCompetence", cascade={"persist"})
     */
    private $poleDeCompetence;

    /**
     * @ORM\ManyToMany(targetEntity="UpjvBundle\Entity\Optionnelle", cascade={"persist"})
     */
    private $optionnelles;

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
     * @return Matiere
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
     * @return Matiere
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
     * Set place.
     *
     * @param int $place
     *
     * @return Matiere
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place.
     *
     * @return int
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * @return mixed
     */
    public function getPoleDeCompetence()
    {
        return $this->poleDeCompetence;
    }

    /**
     * @param mixed $poleDeCompetence
     */
    public function setPoleDeCompetence($poleDeCompetence)
    {
        $this->poleDeCompetence = $poleDeCompetence;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->poleDeCompetence = new \Doctrine\Common\Collections\ArrayCollection();
        $this->optionnelles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add poleDeCompetence.
     *
     * @param \UpjvBundle\Entity\PoleDeCompetence $poleDeCompetence
     *
     * @return Matiere
     */
    public function addPoleDeCompetence(\UpjvBundle\Entity\PoleDeCompetence $poleDeCompetence)
    {
        $this->poleDeCompetence[] = $poleDeCompetence;

        return $this;
    }

    /**
     * Remove poleDeCompetence.
     *
     * @param \UpjvBundle\Entity\PoleDeCompetence $poleDeCompetence
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removePoleDeCompetence(\UpjvBundle\Entity\PoleDeCompetence $poleDeCompetence)
    {
        return $this->poleDeCompetence->removeElement($poleDeCompetence);
    }

    /**
     * Add optionnelle.
     *
     * @param \UpjvBundle\Entity\Optionnelle $optionnelle
     *
     * @return Matiere
     */
    public function addOptionnelle(\UpjvBundle\Entity\Optionnelle $optionnelle)
    {
        $this->optionnelles[] = $optionnelle;

        return $this;
    }

    /**
     * Remove optionnelle.
     *
     * @param \UpjvBundle\Entity\Optionnelle $optionnelle
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeOptionnelle(\UpjvBundle\Entity\Optionnelle $optionnelle)
    {
        return $this->optionnelles->removeElement($optionnelle);
    }

    /**
     * Get optionnelles.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOptionnelles()
    {
        return $this->optionnelles;
    }
}
