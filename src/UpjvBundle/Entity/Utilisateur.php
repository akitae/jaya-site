<?php

namespace UpjvBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Utilisateur
 *
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity(repositoryClass="UpjvBundle\Repository\UtilisateurRepository")
 */
class Utilisateur implements UserInterface, \Serializable
{
    const TYPE_ETUDIANT = 0;
    const TYPE_PROFESSEUR = 1;
    const TYPE_ADMIN = 2;

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
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="motDePasse", type="string", length=255, nullable=true)
     */
    private $motDePasse;

    /**
     * @var string
     *
     * @ORM\Column(name="numeroEtudiant", type="string", length=255, unique=true, nullable=true)
     */
    private $numeroEtudiant;

    /**
     * @var bool
     *
     * @ORM\Column(name="valide", type="boolean")
     */
    private $valide;

    /**
     * @var int
     *
     * @ORM\Column(name="type", type="integer")
     */
    private $type;

    /**
     * @ORM\ManyToMany(targetEntity="UpjvBundle\Entity\Groupe", cascade={"persist"})
     */
    private $groupes;

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
     * @return Utilisateur
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
     * Set prenom.
     *
     * @param string $prenom
     *
     * @return Utilisateur
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom.
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return Utilisateur
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getMotDePasse()
    {
        return $this->motDePasse;
    }

    /**
     * @param string $motDePasse
     */
    public function setMotDePasse($motDePasse)
    {
        $this->motDePasse = $motDePasse;
    }

    /**
     * Set numeroEtudiant.
     *
     * @param string $numeroEtudiant
     *
     * @return Utilisateur
     */
    public function setNumeroEtudiant($numeroEtudiant)
    {
        $this->numeroEtudiant = $numeroEtudiant;

        return $this;
    }

    /**
     * Get numeroEtudiant.
     *
     * @return string
     */
    public function getNumeroEtudiant()
    {
        return $this->numeroEtudiant;
    }

    /**
     * Set valide.
     *
     * @param bool $valide
     *
     * @return Utilisateur
     */
    public function setValide($valide)
    {
        $this->valide = $valide;

        return $this;
    }

    /**
     * Get valide.
     *
     * @return bool
     */
    public function getValide()
    {
        return $this->valide;
    }

    /**
     * Set type.
     *
     * @param int $type
     *
     * @return Utilisateur
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
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
     * Constructor
     */
    public function __construct()
    {
        $this->groupes = new \Doctrine\Common\Collections\ArrayCollection();
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

    public function getRoles()
    {
        return array('ROLE_ADMIN');
    }

    public function getPassword()
    {
        return $this->motDePasse;
    }

    public function getSalt()
    {
        return '';
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function serialize()
    {
        return serialize(array ($this->id, $this->getUsername(), $this->getPassword()));
    }

    public function unserialize($serialized)
    {
        list ($this->id, $this->username, $this->motDePasse) = unserialize($serialized);
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
}
