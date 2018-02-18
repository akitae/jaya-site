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
}
