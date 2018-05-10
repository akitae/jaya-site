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
     * @var int
     *
     * @ORM\Column(name="place_stagiare", type="integer")
     */
    private $placeStagiare = 0;

    /**
     * @ORM\ManyToOne(targetEntity="UpjvBundle\Entity\PoleDeCompetence", cascade={"persist"})
     */
    private $poleDeCompetence;

    /**
     * @ORM\ManyToOne(targetEntity="Semestre", inversedBy="matiere")
     * @ORM\JoinColumn(name="semestre_id", referencedColumnName="id")
     */
    private $semestre;

    private $groupes;

    /**
     * @ORM\ManyToMany(targetEntity="UpjvBundle\Entity\Utilisateur",mappedBy="matieres")
     */
    private $utilisateurs;

    /**
     * @ORM\OneToMany(targetEntity="UpjvBundle\Entity\MatiereOptionelle", mappedBy="matiere")
     */
    private $optionnel;

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
        $this->optionnel = new \Doctrine\Common\Collections\ArrayCollection();
        $this->utilisateurs = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Get semestre.
     *
     * @return \UpjvBundle\Entity\Semestre|null
     */
    public function getSemestre()
    {
        return $this->semestre;
    }

    /**
     * Add groupe.
     *
     * @param \UpjvBundle\Entity\Groupe $groupe
     *
     * @return Matiere
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
  * Get groupes.
  *
  * @return \Doctrine\Common\Collections\Collection
  */
  public function getGroupes()
  {
    return $this->groupes;
  }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getCode()." - ".$this->getNom();
    }

    /**
     * Add utilisateur.
     *
     * @param \UpjvBundle\Entity\Utilisateur $utilisateur
     *
     * @return Matiere
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
     * Get utilisateurs.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUtilisateurs()
    {
        return $this->utilisateurs;
    }

    /**
     * @return int
     */
    public function getPlaceStagiare()
    {
        return $this->placeStagiare;
    }

    /**
     * @param int $placeStagiare
     */
    public function setPlaceStagiare($placeStagiare)
    {
        $this->placeStagiare = $placeStagiare;
    }

    /**
     * @param bool $stagiare
     * @return int
     */
    public function getNbrPlaces($stagiare = false){
        if($stagiare){
            return $this->getPlaceStagiare();
        }else{
            return $this->getPlace();
        }
    }

    public function setNbrPlaces($nbr, $stagiare = false){
        if($stagiare){
            $this->setPlaceStagiare($nbr);
        }else{
            $this->setPlace($nbr);
        }
    }

    /**
     * Set semestre.
     *
     * @param \UpjvBundle\Entity\Semestre|null $semestre
     *
     * @return Matiere
     */
    public function setSemestre(\UpjvBundle\Entity\Semestre $semestre = null)
    {
        $this->semestre = $semestre;

        return $this;
    }

    /**
     * Add optionnel.
     *
     * @param \UpjvBundle\Entity\MatiereOptionelle $optionnel
     *
     * @return Matiere
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
