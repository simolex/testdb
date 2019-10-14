<?php
namespace App\Repository;

use App\Entity\NormProcess;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;



/**
 * @method NormProcess|null find($id, $lockMode = null, $lockVersion = null)
 * @method NormProcess|null findOneBy(array $criteria, array $orderBy = null)
 * @method NormProcess[]    findAll()
 * @method NormProcess[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NormProcessRepository extends ServiceEntityRepository
{
	public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NormProcess::class);
    }

    private function getOrCreateQueryBuilder(QueryBuilder $qb = null)
    {
        return $qb ?: $this->createQueryBuilder('np');
    }
}