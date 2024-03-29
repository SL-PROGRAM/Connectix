<?php

namespace App\Repository;

use App\Entity\ProductionLign;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProductionLign|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductionLign|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductionLign[]    findAll()
 * @method ProductionLign[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductionLignRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProductionLign::class);
    }

    // /**
    //  * @return ProductionLign[] Returns an array of ProductionLign objects
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
    public function findOneBySomeField($value): ?ProductionLign
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
