<?php

namespace App\Repository;

use App\Entity\Anime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @method Anime|null find($id, $lockMode = null, $lockVersion = null)
 * @method Anime|null findOneBy(array $criteria, array $orderBy = null)
 * @method Anime[]    findAll()
 * @method Anime[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Anime::class);
    }

    // /**
    //  * @return Anime[] Returns an array of Anime objects
    //  */
    public function baseList($page = 1,$pageSize = 100)
    {
        $page = ($page - 1) * $pageSize;

        $query = $this->createQueryBuilder('a')
            #->andWhere('a.title = :val')->setParameter('val', $value)
            ->orderBy('a.id', 'DESC')
            ->setFirstResult($page)
            ->setMaxResults($pageSize)
            ->getQuery();#->getResult();

        // gera paginacao e count
        $paginator = new Paginator($query, $fetchJoinCollection = false);
        
        return [
            // retorna como array
            'data' => $paginator->getIterator()->getArrayCopy(),
            'total'=>$paginator->count() 
        ];
    }

    /* 
    
    O que é o paginator

        // Perform a Count query using `DISTINCT` keyword.
        // Perform a Limit Subquery with `DISTINCT` to find all ids of the entity in from on the current page.
        // Perform a WHERE IN query to get all results for the current page.
        // Se tiver subquery ou join , fetchjoin = true
    */
    

    /*
    public function findOneBySomeField($value): ?Anime
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
