<?php

namespace App\Repository;

use App\Entity\LogementSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LogementSearch|null find($id, $lockMode = null, $lockVersion = null)
 * @method LogementSearch|null findOneBy(array $criteria, array $orderBy = null)
 * @method LogementSearch[]    findAll()
 * @method LogementSearch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogementSearchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LogementSearch::class);
    }

    // /**
    //  * @return LogementSearch[] Returns an array of LogementSearch objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LogementSearch
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
