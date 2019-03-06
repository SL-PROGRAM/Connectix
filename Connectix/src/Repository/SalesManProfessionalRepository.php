<?php

namespace App\Repository;

use App\Entity\SalesManProfessional;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SalesManProfessional|null find($id, $lockMode = null, $lockVersion = null)
 * @method SalesManProfessional|null findOneBy(array $criteria, array $orderBy = null)
 * @method SalesManProfessional[]    findAll()
 * @method SalesManProfessional[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalesManProfessionalRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SalesManProfessional::class);
    }

    // /**
    //  * @return SalesManProfessional[] Returns an array of SalesManProfessional objects
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
    public function findOneBySomeField($value): ?SalesManProfessional
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
