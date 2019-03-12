<?php

namespace App\Repository;

use App\Entity\ProductionOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProductionOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductionOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductionOrder[]    findAll()
 * @method ProductionOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductionOrderRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProductionOrder::class);
    }

    // /**
    //  * @return ProductionOrder[] Returns an array of ProductionOrder objects
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
    public function findOneBySomeField($value): ?ProductionOrder
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
