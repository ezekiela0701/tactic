<?php

namespace App\Repository;

use App\Entity\DocumentExam;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method DocumentExam|null find($id, $lockMode = null, $lockVersion = null)
 * @method DocumentExam|null findOneBy(array $criteria, array $orderBy = null)
 * @method DocumentExam[]    findAll()
 * @method DocumentExam[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DocumentExamRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, DocumentExam::class);
    }

    // /**
    //  * @return DocumentExam[] Returns an array of DocumentExam objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?DocumentExam
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
