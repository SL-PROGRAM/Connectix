<?php

namespace App\Repository;

use App\Entity\SalesManDirector;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SalesManDirector|null find($id, $lockMode = null, $lockVersion = null)
 * @method SalesManDirector|null findOneBy(array $criteria, array $orderBy = null)
 * @method SalesManDirector[]    findAll()
 * @method SalesManDirector[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalesManDirectorRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SalesManDirector::class);
    }

    // /**
    //  * @return SalesManDirector[] Returns an array of SalesManDirector objects
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
    public function findOneBySomeField($value): ?SalesManDirector
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
