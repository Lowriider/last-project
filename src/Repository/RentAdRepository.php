<?php

namespace App\Repository;

use App\Entity\RentAd;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RentAd|null find($id, $lockMode = null, $lockVersion = null)
 * @method RentAd|null findOneBy(array $criteria, array $orderBy = null)
 * @method RentAd[]    findAll()
 * @method RentAd[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RentAdRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RentAd::class);
    }

    // /**
    //  * @return RentAd[] Returns an array of RentAd objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RentAd
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
