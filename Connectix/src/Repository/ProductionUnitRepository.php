<?php

namespace App\Repository;

use App\Entity\ProductionUnit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProductionUnit|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductionUnit|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductionUnit[]    findAll()
 * @method ProductionUnit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductionUnitRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProductionUnit::class);
    }

    // /**
    //  * @return ProductionUnit[] Returns an array of ProductionUnit objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProductionUnit
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
