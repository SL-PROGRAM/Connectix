<?php

namespace App\Repository;

use App\Entity\SalesMan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SalesMan|null find($id, $lockMode = null, $lockVersion = null)
 * @method SalesMan|null findOneBy(array $criteria, array $orderBy = null)
 * @method SalesMan[]    findAll()
 * @method SalesMan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalesManRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SalesMan::class);
    }

    // /**
    //  * @return SalesMan[] Returns an array of SalesMan objects
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
    public function findOneBySomeField($value): ?SalesMan
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
