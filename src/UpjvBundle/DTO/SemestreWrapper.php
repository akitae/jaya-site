<?php
/**
 * Created by PhpStorm.
 * User: Florian
 * Date: 12/03/2018
 * Time: 21:40
 */

namespace UpjvBundle\DTO;


class SemestreWrapper
{

    private $id;

    private $nom;

    private $dateDebut;

    private $dateFin;

    private $dateDebutChoix;

    private $dateFinChoix;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * @param mixed $dateDebut
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;
    }

    /**
     * @return mixed
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * @param mixed $dateFin
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;
    }

    /**
     * @return mixed
     */
    public function getDateDebutChoix()
    {
        return $this->dateDebutChoix;
    }

    /**
     * @param mixed $dateDebutChoix
     */
    public function setDateDebutChoix($dateDebutChoix)
    {
        $this->dateDebutChoix = $dateDebutChoix;
    }

    /**
     * @return mixed
     */
    public function getDateFinChoix()
    {
        return $this->dateFinChoix;
    }

    /**
     * @param mixed $dateFinChoix
     */
    public function setDateFinChoix($dateFinChoix)
    {
        $this->dateFinChoix = $dateFinChoix;
    }

}