<?php

namespace App\Repository;

use App\Entity\AnimaProgram;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method AnimaProgram|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnimaProgram|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnimaProgram[]    findAll()
 * @method AnimaProgram[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimaProgramRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnimaProgram::class);
    }

    // /**
    //  * @return AnimaProgram[] Returns an array of AnimaProgram objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AnimaProgram
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
