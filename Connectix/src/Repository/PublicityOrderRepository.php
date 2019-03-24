<?php

namespace App\Repository;

use App\Entity\PublicityOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PublicityOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method PublicityOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method PublicityOrder[]    findAll()
 * @method PublicityOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PublicityOrderRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PublicityOrder::class);
    }

    // /**
    //  * @return PublicityOrder[] Returns an array of PublicityOrder objects
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
    public function findOneBySomeField($value): ?PublicityOrder
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
