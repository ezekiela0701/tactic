<?php

namespace App\Repository;

use App\Entity\VideosLesson;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VideosLesson|null find($id, $lockMode = null, $lockVersion = null)
 * @method VideosLesson|null findOneBy(array $criteria, array $orderBy = null)
 * @method VideosLesson[]    findAll()
 * @method VideosLesson[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideosLessonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VideosLesson::class);
    }

    // /**
    //  * @return VideosLesson[] Returns an array of VideosLesson objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VideosLesson
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
