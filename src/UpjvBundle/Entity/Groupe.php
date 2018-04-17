<?php

namespace UpjvBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Groupe
 *
 * @ORM\Table(name="groupe")
 * @ORM\Entity(repositoryClass="UpjvBundle\Repository\GroupeRepository")
 */
class Groupe
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
     * @ORM\ManyToMany(targetEntity="UpjvBundle\Entity\Utilisateur", cascade={"persist"})
     */
    private $utilisateurs;

    /**
     * @ORM\ManyToOne(targetEntity="Matiere", inversedBy="matiere")
     * @ORM\JoinColumn(name="matiere_id", referencedColumnName="id")
     */
    private $matiere;


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
     * @return mixed
     */
    public function getUtilisateurs()
    {
        return $this->utilisateurs;
    }

    /**
     * @param mixed $utilisateurs
     */
    public function setUtilisateurs($utilisateurs)
    {
        $this->utilisateurs = $utilisateurs;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->utilisateurs = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add utilisateur.
     *
     * @param \UpjvBundle\Entity\Utilisateur $utilisateur
     *
     * @return Groupe
     */
    public function addUtilisateur(\UpjvBundle\Entity\Utilisateur $utilisateur)
    {
        $this->utilisateurs[] = $utilisateur;

        return $this;
    }

    /**
     * Remove utilisateur.
     *
     * @param \UpjvBundle\Entity\Utilisateur $utilisateur
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeUtilisateur(\UpjvBundle\Entity\Utilisateur $utilisateur)
    {
        return $this->utilisateurs->removeElement($utilisateur);
    }

    /**
     * Set matiere.
     *
     * @param \UpjvBundle\Entity\Matiere|null $matiere
     *
     * @return Groupe
     */
    public function setMatiere(\UpjvBundle\Entity\Matiere $matiere = null)
    {
        $this->matiere = $matiere;

        return $this;
    }

    /**
     * Get matiere.
     *
     * @return \UpjvBundle\Entity\Matiere|null
     */
    public function getMatiere()
    {
        return $this->matiere;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getNom();
    }

}
