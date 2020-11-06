<?php

namespace App\Repository;

use App\Entity\LodgingCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LodgingCategory|null find($id, $lockMode = null, $lockVersion = null)
 * @method LodgingCategory|null findOneBy(array $criteria, array $orderBy = null)
 * @method LodgingCategory[]    findAll()
 * @method LodgingCategory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LodgingCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LodgingCategory::class);
    }

    // /**
    //  * @return LodgingCategory[] Returns an array of LodgingCategory objects
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
    public function findOneBySomeField($value): ?LodgingCategory
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
