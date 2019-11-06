<?php

namespace App\Repository;

use App\Entity\NormObject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method NormObject|null find($id, $lockMode = null, $lockVersion = null)
 * @method NormObject|null findOneBy(array $criteria, array $orderBy = null)
 * @method NormObject[]    findAll()
 * @method NormObject[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NormObjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NormObject::class);
    }

    // /**
    //  * @return NormObject[] Returns an array of NormObject objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NormObject
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
