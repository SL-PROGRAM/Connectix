<?php

namespace App\Repository;

use App\Entity\Seasonality;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Seasonality|null find($id, $lockMode = null, $lockVersion = null)
 * @method Seasonality|null findOneBy(array $criteria, array $orderBy = null)
 * @method Seasonality[]    findAll()
 * @method Seasonality[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SeasonalityRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Seasonality::class);
    }

    // /**
    //  * @return Seasonality[] Returns an array of Seasonality objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Seasonality
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
