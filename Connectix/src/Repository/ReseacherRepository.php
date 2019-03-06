<?php

namespace App\Repository;

use App\Entity\Reseacher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Reseacher|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reseacher|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reseacher[]    findAll()
 * @method Reseacher[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReseacherRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Reseacher::class);
    }

    // /**
    //  * @return Reseacher[] Returns an array of Reseacher objects
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
    public function findOneBySomeField($value): ?Reseacher
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
