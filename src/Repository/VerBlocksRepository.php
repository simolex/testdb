<?php
namespace App\Repository;

use App\Entity\VerBlocks;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;



/**
 * @method VerBlocks|null find($id, $lockMode = null, $lockVersion = null)
 * @method VerBlocks|null findOneBy(array $criteria, array $orderBy = null)
 * @method VerBlocks[]    findAll()
 * @method VerBlocks[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VerBlocksRepository extends ServiceEntityRepository
{
	public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VerBlocks::class);
    }

    private function getOrCreateQueryBuilder(QueryBuilder $qb = null)
    {
        return $qb ?: $this->createQueryBuilder('vb');
    }


    /**
     * @return VerBlocks[] Returns an array of VerBlocks objects
     */
    public function getAllDistinctType()
    {
    	$em = $this->getEntityManager();
    	$query = $em->createQuery(
    		'SELECT substr()
    		FROM VerBlocks vb
    		group by vb.type'
    	)

    	return $this->getOrCreateQueryBuilder()
    		->groupBy('vb.type')
    		->groupBy('')
    		->getQuery()
            ->execute()
    	;
    }
}