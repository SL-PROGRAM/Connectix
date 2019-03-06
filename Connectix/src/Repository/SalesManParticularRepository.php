<?php

namespace App\Repository;

use App\Entity\SalesManParticular;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SalesManParticular|null find($id, $lockMode = null, $lockVersion = null)
 * @method SalesManParticular|null findOneBy(array $criteria, array $orderBy = null)
 * @method SalesManParticular[]    findAll()
 * @method SalesManParticular[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalesManParticularRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SalesManParticular::class);
    }

    // /**
    //  * @return SalesManParticular[] Returns an array of SalesManParticular objects
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
    public function findOneBySomeField($value): ?SalesManParticular
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
