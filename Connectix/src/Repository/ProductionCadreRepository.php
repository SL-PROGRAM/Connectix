<?php

namespace App\Repository;

use App\Entity\ProductionCadre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProductionCadre|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductionCadre|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductionCadre[]    findAll()
 * @method ProductionCadre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductionCadreRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProductionCadre::class);
    }

    // /**
    //  * @return ProductiorCadre[] Returns an array of ProductiorCadre objects
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
    public function findOneBySomeField($value): ?ProductiorCadre
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
