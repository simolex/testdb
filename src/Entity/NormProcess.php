<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VerProcess
 *
 * @ORM\Table(
 *     name="OTHERGKN.NORM_PROCESS",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(
 *             name="pk_process_id", columns={"ID"}
 *         )
 *     },
 *     indexes={
 *         @ORM\Index(name="i_norm_process_parent_id", columns={"PARENT_ID"}),
 *         @ORM\Index(name="i_norm_process_block_id", columns={"ID_NORM_BLOCK"})
 *     }
 * )
 * @ORM\Entity
 */
class NormProcess
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="SEQ_NORM_PROCESS_ID", allocationSize=2, initialValue=1)
     */
    private $id;


    /**
     * @var int|null
     *
     * @ORM\Column(name="PARENT_ID", type="integer", nullable=true)
     */
    private $parentId;

     /**
     * @var int|null
     *
     * @ORM\Column(name="ID_NORM_BLOCK", type="integer", nullable=true)
     */
    private $idNormBlock;

    /**
     * @var string|null
     *
     * @ORM\Column(name="NOTE", type="string", length=1000, nullable=true)
     */
    private $note;
}
