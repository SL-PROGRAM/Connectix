<?php

namespace App\Repository;

use App\Entity\Socity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Socity|null find($id, $lockMode = null, $lockVersion = null)
 * @method Socity|null findOneBy(array $criteria, array $orderBy = null)
 * @method Socity[]    findAll()
 * @method Socity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SocityRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Socity::class);
    }

    // /**
    //  * @return Socity[] Returns an array of Socity objects
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
    public function findOneBySomeField($value): ?Socity
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
