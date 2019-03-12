<?php

namespace App\Repository;

use App\Entity\ReseachOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ReseachOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReseachOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReseachOrder[]    findAll()
 * @method ReseachOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReseachOrderRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ReseachOrder::class);
    }

    // /**
    //  * @return ReseachOrder[] Returns an array of ReseachOrder objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ReseachOrder
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
