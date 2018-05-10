<?php

namespace UpjvBundle\Repository;
use UpjvBundle\Entity\Matiere;
use UpjvBundle\Entity\Semestre;

/**
 * OptionnelleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class MatiereOptionelleRepository extends \Doctrine\ORM\EntityRepository
{
    public function findBySemestre(Semestre $semestre){
        return $this
            ->createQueryBuilder('o')
            ->join('o.matiere','matiere')
            ->where('matiere.semestre = :semestre')
            ->setParameter('semestre',$semestre)
            ->getQuery()
            ->getResult()
            ;
    }

    public function countNbrOptionEtudiantWant(Matiere $matiere){
        return $this
            ->createQueryBuilder('o')
            ->select('COUNT(o)')
            ->where('o.matiere = :matiere')
            ->setParameter('matiere',$matiere)
            ->getQuery()
            ->getSingleScalarResult()
            ;
    }
}
