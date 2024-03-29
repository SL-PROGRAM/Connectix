<?php

namespace App\Repository;

use App\Entity\Factory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Factory|null find($id, $lockMode = null, $lockVersion = null)
 * @method Factory|null findOneBy(array $criteria, array $orderBy = null)
 * @method Factory[]    findAll()
 * @method Factory[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FactoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Factory::class);
    }

    // /**
    //  * @return Factory[] Returns an array of Factory objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Factory
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
