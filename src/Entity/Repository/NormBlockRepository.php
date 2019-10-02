<?php
namespace App\Entity\Repository;

use App\Entity\NormBlock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;



/**
 * @method NormBlock|null find($id, $lockMode = null, $lockVersion = null)
 * @method NormBlock|null findOneBy(array $criteria, array $orderBy = null)
 * @method NormBlock[]    findAll()
 * @method NormBlock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NormBlockRepository extends ServiceEntityRepository
{
	public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NormBlock::class);
    }

    private function getOrCreateQueryBuilder(QueryBuilder $qb = null)
    {
        return $qb ?: $this->createQueryBuilder('nb');
    }


    /**
     * @return NormBlock[] Returns an array of VerBlocks objects
     */
    /*public function getAllDistinctType()
    {
    	$em = $this->getEntityManager();
    	$query = $em->createQuery(
    		'SELECT substr()
    		FROM NormBlock vb
    		group by vb.type'
    	)

    	return $this->getOrCreateQueryBuilder()
    		->groupBy('vb.type')
    		->groupBy('')
    		->getQuery()
            ->execute()
    	;
    }*/
}