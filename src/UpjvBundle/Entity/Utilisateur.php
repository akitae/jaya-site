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

    /**
     * Utilisateur constructor.
     */
    public function __construct()
    {
        $this->setEnabled(false);
        $this->setTypeUtilisateur('ETUDIANT');
        $this->setConfirmationEmail(false);
    }

    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="nom", type="string", length=180)
     */
    private $nom = "aaa";

    /**
     * @ORM\Column(name="prenom", type="string", length=180)
     */
    private $prenom = "aaa";

    /**
     * @ORM\Column(name="numeroEtudiant", type="integer", unique=true)
     * @Assert\Regex(
     *     pattern="/^([0-9]*)$/",
     *     match=true,
     *     message="Le numéro étudiant est invalide."
     * )
     */

    private $numeroEtudiant = "45545";

    private $parcours;

    /**
     * @ORM\ManyToMany(targetEntity="UpjvBundle\Entity\Groupe", cascade={"persist"})
     */
    private $groupes;

    /**
     * @ORM\ManyToMany(targetEntity="Matiere", inversedBy="utilisateurs")
     */
    private $matieres;

    /**
     * @ORM\Column(name="confirmation_email", type="boolean")
     */
    private $confirmation_email = false;

    /**
     * @ORM\Column(name="typeUtilisateur", type="string", columnDefinition="enum('ETUDIANT', 'PROFESSEUR', 'ADMIN')")
     */
    private $typeUtilisateur;

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
    public function getConfirmationEmail()
    {
        return $this->confirmation_email;
    }

    /**
     * @param mixed $confirmation_email
     */
    public function setConfirmationEmail($confirmation_email)
    {
        $this->confirmation_email = $confirmation_email;
    }

    /**
     * @return mixed
     */
    public function getTypeUtilisateur()
    {
        return $this->typeUtilisateur;
    }

    /**
     * @param mixed $typeUtilisateur
     */
    public function setTypeUtilisateur($typeUtilisateur)
    {
        $this->typeUtilisateur = $typeUtilisateur;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getNom();
    }

    /**
     * Add matiere.
     *
     * @param \UpjvBundle\Entity\Matiere $matiere
     *
     * @return Utilisateur
     */
    public function addMatiere(\UpjvBundle\Entity\Matiere $matiere)
    {
        $this->matieres[] = $matiere;

        return $this;
    }

    /**
     * Remove groupe.
     *
     * @param \UpjvBundle\Entity\Groupe $groupe
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeGroupe(\UpjvBundle\Entity\Groupe $groupe)
    {
        return $this->groupes->removeElement($groupe);
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
     * Add groupe.
     *
     * @param \UpjvBundle\Entity\Groupe $groupe
     *
     * @return Utilisateur
     */
    public function addGroupe(\UpjvBundle\Entity\Groupe $groupe)
    {
        $this->groupes[] = $groupe;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGroupes()
    {
        return $this->groupes;
    }
    /**
     * @param mixed $groupes
     */
    public function setGroupes($groupes)
    {
        $this->groupes = $groupes;
    }
}
