<?php

namespace App\Repository;

use App\Entity\ResearcherDirector;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ResearcherDirector|null find($id, $lockMode = null, $lockVersion = null)
 * @method ResearcherDirector|null findOneBy(array $criteria, array $orderBy = null)
 * @method ResearcherDirector[]    findAll()
 * @method ResearcherDirector[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ResearcherDirectorRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ResearcherDirector::class);
    }

    // /**
    //  * @return ResearcherDirector[] Returns an array of ResearcherDirector objects
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
    public function findOneBySomeField($value): ?ResearcherDirector
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
