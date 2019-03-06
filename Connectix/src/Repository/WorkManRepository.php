<?php

namespace App\Repository;

use App\Entity\WorkMan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method WorkMan|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorkMan|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorkMan[]    findAll()
 * @method WorkMan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorkManRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, WorkMan::class);
    }

    // /**
    //  * @return WorkMan[] Returns an array of WorkMan objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WorkMan
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
