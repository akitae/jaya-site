<?php

namespace UpjvBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pole De competence Parcours
 *
 * @ORM\Table(name="pole_de_competence_parcours")
 * @ORM\Entity(repositoryClass="UpjvBundle\Repository\PoleDeCompetenceParcoursRepository")
 */
class PoleDeCompetenceParcours
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
     * @var int
     *
     * @ORM\Column(name="nbrMatiereOptionnelle", type="integer")
     */
    private $nbrMatiereOptionnelle;

    /**
     * @ORM\ManyToOne(targetEntity="UpjvBundle\Entity\Parcours", cascade={"persist"}, inversedBy="polesDeCompetence")
     */
    private $parcours;

    /**
     * @ORM\ManyToOne(targetEntity="UpjvBundle\Entity\Matiere", cascade={"persist"})
     */
    private $matiere;

    /**
     * @ORM\ManyToOne(targetEntity="UpjvBundle\Entity\PoleDeCompetence", cascade={"persist"})
     */
    private $poleDeCompetence;

    /**
     * @return int
     */
    public function getNbrMatiereOptionnelle()
    {
        return $this->nbrMatiereOptionnelle;
    }

    /**
     * @param int $nbrMatiereOptionnelle
     */
    public function setNbrMatiereOptionnelle($nbrMatiereOptionnelle)
    {
        $this->nbrMatiereOptionnelle = $nbrMatiereOptionnelle;
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
     * @return mixed
     */
    public function getMatiere()
    {
        return $this->matiere;
    }

    /**
     * @param mixed $matiere
     */
    public function setMatiere($matiere)
    {
        $this->matiere = $matiere;
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


}
