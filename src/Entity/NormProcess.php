<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VerProcess
 *
 * @ORM\Table(
 *     name="NORM_PROCESS",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(
 *             name="PK_NORM_PROCESS_ID", columns={"ID"}
 *         )
 *     },
 *     indexes={
 *         @ORM\Index(name="i_norm_process_parent_id", columns={"PARENT_ID"}),
 *         @ORM\Index(name="i_norm_process_block_id", columns={"ID_NORM_BLOCK"})
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\NormProcessRepository")
 */
class NormProcess
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="SEQ_NORM_PROCESS_ID", allocationSize=1, initialValue=1)
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
     * @ORM\Column(name="STAGE", type="string", length=100, nullable=true)
     */
    private $stage;

    /**
     * @var string|null
     *
     * @ORM\Column(name="NOTE", type="string", length=1000, nullable=true)
     */
    private $note;


    public function getId(): int
    {
        return $this->id;
    }

    public function getParentId()
    {
        return $this->parentId;
    }

    public function getNormBlock()
    {
        return $this->idNormBlock;
    }

    public function getNote()
    {
        return $this->note;
    }

    public function getStage()
    {
        return $this->stage;
    }

    public function setStage($stage)
    {
        $this->stage = $stage;
    }
    public function createProcess(?string $note, ?int $blockId = null, ?int $parentId = null)
    {
        $this->note = $note;
        if($blockId !== null) {
            $this->idNormBlock = $blockId;
        }
        if($parentId !== null) {
            $this->parentId = $parentId;
        }

    }


}
