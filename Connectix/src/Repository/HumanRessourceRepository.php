<?php

namespace App\Repository;

use App\Entity\HumanRessource;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method HumanRessource|null find($id, $lockMode = null, $lockVersion = null)
 * @method HumanRessource|null findOneBy(array $criteria, array $orderBy = null)
 * @method HumanRessource[]    findAll()
 * @method HumanRessource[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HumanRessourceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, HumanRessource::class);
    }

    // /**
    //  * @return HumanRessource[] Returns an array of HumanRessource objects
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
    public function findOneBySomeField($value): ?HumanRessource
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
