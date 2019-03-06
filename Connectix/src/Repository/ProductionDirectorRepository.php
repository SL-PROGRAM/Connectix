<?php

namespace App\Repository;

use App\Entity\ProductionDirector;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProductionDirector|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductionDirector|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductionDirector[]    findAll()
 * @method ProductionDirector[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductionDirectorRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProductionDirector::class);
    }

    // /**
    //  * @return ProductionDirector[] Returns an array of ProductionDirector objects
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
    public function findOneBySomeField($value): ?ProductionDirector
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
