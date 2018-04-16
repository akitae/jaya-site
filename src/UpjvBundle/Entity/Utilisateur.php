<?php

namespace UpjvBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity(repositoryClass="UpjvBundle\Repository\UtilisateurRepository")
 */
class Utilisateur extends BaseUser
{
    const TYPE_ETUDIANT = 0;
    const TYPE_PROFESSEUR = 1;
    const TYPE_ADMIN = 2;

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="nom", type="string", length=180)
     */
    private $nom;

    /**
     * @ORM\Column(name="prenom", type="string", length=180)
     */
    private $prenom;

    /**
     * @ORM\Column(name="numeroEtudiant", type="integer", unique=true)
     * @Assert\Regex(
     *     pattern="/^([0-9]*)$/",
     *     match=true,
     *     message="Le numéro étudiant est invalide"
     * )
     */
    private $numeroEtudiant;

    private $password_check;

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
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return mixed
     */
    public function getNumeroEtudiant()
    {
        return $this->numeroEtudiant;
    }

    /**
     * @param mixed $numeroEtudiant
     */
    public function setNumeroEtudiant($numeroEtudiant)
    {
        $this->numeroEtudiant = $numeroEtudiant;
    }

    /**
     * @return mixed
     */
    public function getPasswordCheck()
    {
        return $this->password_check;
    }

    /**
     * @param mixed $password_check
     */
    public function setPasswordCheck($password_check)
    {
        $this->password_check = $password_check;
    }

}
