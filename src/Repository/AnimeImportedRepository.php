<?php

namespace App\Repository;

use App\Entity\AnimeImported;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
#use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @method AnimeImported|null find($id, $lockMode = null, $lockVersion = null)
 * @method AnimeImported|null findOneBy(array $criteria, array $orderBy = null)
 * @method AnimeImported[]    findAll()
 * @method AnimeImported[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimeImportedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AnimeImported::class);
    }

    // /**
    //  * @return AnimeImported[] Returns an array of AnimeImported objects
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
    public function findOneBySomeField($value): ?AnimeImported
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
