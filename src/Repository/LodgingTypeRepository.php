<?php

namespace App\Repository;

use App\Entity\LodgingType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LodgingType|null find($id, $lockMode = null, $lockVersion = null)
 * @method LodgingType|null findOneBy(array $criteria, array $orderBy = null)
 * @method LodgingType[]    findAll()
 * @method LodgingType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LodgingTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LodgingType::class);
    }

    // /**
    //  * @return LodgingType[] Returns an array of LodgingType objects
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
    public function findOneBySomeField($value): ?LodgingType
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
