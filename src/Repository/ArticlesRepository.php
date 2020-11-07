<?php

namespace App\Repository;

use App\Entity\Articles;
use App\Entity\ArticlesSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder as ORMQueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Articles|null find($id, $lockMode = null, $lockVersion = null)
 * @method Articles|null findOneBy(array $criteria, array $orderBy = null)
 * @method Articles[]    findAll()
 * @method Articles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticlesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Articles::class);
    }

    /**
     * @return Query
     */
    public function findAllVisible(ArticlesSearch $search): Query
    {
        $query = $this->findVisibleQuery();

        if ($search->getMinPublished()) {
            $query = $query
                ->andwhere('l.published <= :maxpublished')
                ->setParameter('maxpublished', $search->getMinPublished());
        }
        return $query->getQuery();
    }

    // /**
    //  * @return Articles[] Returns an array of Articles objects
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
    public function findOneBySomeField($value): ?Articles
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
