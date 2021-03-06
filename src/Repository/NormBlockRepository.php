<?php

namespace App\Repository;

use App\Entity\NormBlock;
use Doctrine\ORM\EntityManagerInterface;
//use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\QueryBuilder;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;



/**
 * @method persistAsFirstChild($node)
 * @method persistAsFirstChildOf($node, $parent)
 * @method persistAsLastChild($node)
 * @method persistAsLastChildOf($node, $parent)
 * @method persistAsNextSibling($node)
 * @method persistAsNextSiblingOf($node, $sibling)
 * @method persistAsPrevSibling($node)
 * @method persistAsPrevSiblingOf($node, $sibling)
 */
class NormBlockRepository extends NestedTreeRepository
{
    public function __construct(EntityManagerInterface $em)
    {
        $class = $em->getClassMetadata(NormBlock::class);
        parent::__construct($em, $class);
       // $this->initializeTreeRepository($em, $class);
    }

    private function getOrCreateQueryBuilder(QueryBuilder $qb = null)
    {
        return $qb ?: $this->createQueryBuilder('nb');
    }

    /**
     * {@inheritDoc}
     */
    public function getChildrenWithDepthQueryBuilder($node = null, $depth = null, $direct = false, $sortByField = null, $direction = 'ASC', $includeNode = false)
    {
        $meta = $this->getClassMetadata();
        $config = $this->listener->getConfiguration($this->_em, $meta->name);
        //dd($config);

        $qb = $this->getChildrenQueryBuilder($node, $direct, $sortByField, $direction, $includeNode);
        if ($depth !== null) {
            $qb->andWhere($qb->expr()->lte('node.'.$config['level'], $depth));
        }
        return $qb;
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