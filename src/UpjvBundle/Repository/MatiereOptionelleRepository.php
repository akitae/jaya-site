<?php

namespace UpjvBundle\Repository;


use UpjvBundle\Entity\Utilisateur;

class MatiereOptionelleRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * @param $user Utilisateur
     * @return mixed
     */
    public function findByUser($user) {
        $queryBuilder = $this->createQueryBuilder('e');
        $queryBuilder
            ->where('e.user = :user')
            ->setParameter('user', $user)
            ->orderBy("e.ordre");

        return $queryBuilder->getQuery()->getResult();
    }

}