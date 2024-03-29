<?php

namespace App\Repository;

use App\Entity\HumanResource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method HumanResource|null find($id, $lockMode = null, $lockVersion = null)
 * @method HumanResource|null findOneBy(array $criteria, array $orderBy = null)
 * @method HumanResource[]    findAll()
 * @method HumanResource[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HumanRessourceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, HumanResource::class);
    }

    // /**
    //  * @return HumanResource[] Returns an array of HumanResource objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HumanResource
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
