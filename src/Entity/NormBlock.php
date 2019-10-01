<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VerBlocks
 *
 * @ORM\Table(
 *     name="OTHERGKN.NORM_BLOCK",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(
 *             name="pk_block_id", columns={"ID"}
 *         )
 *     },
 * )
 * @ORM\Entity(repositoryClass="App\Entity\Repository\NormBlockRepository")
 */
class NormBlock
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID", type="integer", nullable=false, options={"comment"="id"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="SEQ_NORM_BLOCK_ID", allocationSize=2, initialValue=1)
     */
    private $Id;
}
