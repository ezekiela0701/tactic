<?php

namespace App\Repository;

use App\Entity\HomePresentation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HomePresentation|null find($id, $lockMode = null, $lockVersion = null)
 * @method HomePresentation|null findOneBy(array $criteria, array $orderBy = null)
 * @method HomePresentation[]    findAll()
 * @method HomePresentation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HomePresentationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HomePresentation::class);
    }

    // /**
    //  * @return HomePresentation[] Returns an array of HomePresentation objects
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
    public function findOneBySomeField($value): ?HomePresentation
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
