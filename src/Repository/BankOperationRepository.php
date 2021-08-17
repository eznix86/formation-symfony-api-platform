<?php

namespace App\Repository;

use App\Entity\BankOperation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BankOperation|null find($id, $lockMode = null, $lockVersion = null)
 * @method BankOperation|null findOneBy(array $criteria, array $orderBy = null)
 * @method BankOperation[]    findAll()
 * @method BankOperation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BankOperationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BankOperation::class);
    }

    // /**
    //  * @return BankOperation[] Returns an array of BankOperation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BankOperation
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
