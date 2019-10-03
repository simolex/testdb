<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Query\ResultSetMappingBuilder;

class NormBlockFixtures extends Fixture
{
	private static $GET_OLD_BLOCKS_TABLE = '
	select id, ver_type, attr, message
	from OTHERGKN.VER_BLOCKS
	order by id';

    public function load(ObjectManager $manager)
    {
    	$connection = $manager->getConnection('oracle');
    	$stmt = $connection->prepare($this->GET_OLD_BLOCKS_TABLE);
    	$stmt->execute();
    	dd($stmt->fetchAll());
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
