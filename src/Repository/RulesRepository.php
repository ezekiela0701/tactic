<?php

namespace App\Repository;

use App\Entity\Rules;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Rules|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rules|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rules[]    findAll()
 * @method Rules[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RulesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rules::class);
    }

    // /**
    //  * @return Rules[] Returns an array of Rules objects
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
    public function findOneBySomeField($value): ?Rules
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function findRules()
    {
        return $this->createQueryBuilder('r')
            ->getQuery()
            ->getResult()
        ;
    }
    public function getInfo()
    {
        return $this->createQueryBuilder('c')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
