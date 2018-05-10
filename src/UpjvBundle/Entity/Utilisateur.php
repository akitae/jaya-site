<?php

namespace UpjvBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity(repositoryClass="UpjvBundle\Repository\UtilisateurRepository")
 */
class Utilisateur extends BaseUser
{

    const ROLE_ETUDIANT = 'ROLE_ETUDIANT';

    const ROLE_PROFESSEUR = 'ROLE_PROFESSEUR';

    const ROLE_ADMIN  = 'ROLE_ADMIN';

    /**
     * Utilisateur constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->setEnabled(false);
        $this->setRoles(array());
        $this->optionnel = new ArrayCollection();
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
    private $nom;

    /**
     * @ORM\Column(name="prenom", type="string", length=180)
     */
    private $prenom;

    /**
     * @ORM\Column(name="numeroEtudiant", type="integer", unique=true, nullable=true)
     * @Assert\Regex(
     *     pattern="/^([0-9]*)$/",
     *     match=true,
     *     message="Le numéro étudiant est invalide."
     * )
     */
    private $numeroEtudiant;

    /**
     * @ORM\ManyToOne(targetEntity="UpjvBundle\Entity\Parcours", inversedBy="parcours")
     */
    private $parcours;

    /**
     * @ORM\ManyToMany(targetEntity="Matiere", inversedBy="utilisateurs")
     *  @ORM\OrderBy({"code" = "ASC"})
     */
    private $matieres;

    /**
     * @ORM\ManyToMany(targetEntity="UpjvBundle\Entity\Groupe", cascade={"persist"})
     */
    private $groupes;

    /**
     * @ORM\OneToMany(targetEntity="UpjvBundle\Entity\MatiereOptionelle", mappedBy="user")
     */
    private $optionnel;

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
     * @return string
     */
    public function __toString()
    {
        return $this->getNom();
    }


    /**
     * Add optionnel.
     *
     * @param \UpjvBundle\Entity\MatiereOptionelle $optionnel
     *
     * @return Utilisateur
     */
    public function addOptionnel(\UpjvBundle\Entity\MatiereOptionelle $optionnel)
    {
        $this->optionnel[] = $optionnel;

        return $this;
    }

    /**
     * Remove optionnel.
     *
     * @param \UpjvBundle\Entity\MatiereOptionelle $optionnel
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeOptionnel(\UpjvBundle\Entity\MatiereOptionelle $optionnel)
    {
        return $this->optionnel->removeElement($optionnel);
    }

    /**
     * Get optionnel.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOptionnel()
    {
        return $this->optionnel;
    }
}
