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
     * @ORM\ManyToMany(targetEntity="UpjvBundle\Entity\Semestre", cascade={"persist"})
     */
    private $semestres;

    private $matieres;

    private $matiereOptionnelle;

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
        return $this->semestres->matiereremoveElement($semestre);
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

    public function __toString() {

      return $this->nom;

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
}
