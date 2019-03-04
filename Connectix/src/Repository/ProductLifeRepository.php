<?php

namespace App\Repository;

use App\Entity\ProductLife;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProductLife|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductLife|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductLife[]    findAll()
 * @method ProductLife[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductLifeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProductLife::class);
    }

    // /**
    //  * @return ProductLife[] Returns an array of ProductLife objects
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
    public function findOneBySomeField($value): ?ProductLife
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
