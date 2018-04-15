<?php

namespace UpjvBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

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

}
