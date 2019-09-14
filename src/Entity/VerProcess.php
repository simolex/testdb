<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VerProcess
 *
 * @ORM\Table(name="VER_PROCESS", indexes={@ORM\Index(name="i_ver_process_parent_id", columns={"PARENT_ID"}), @ORM\Index(name="i_ver_process_block_id", columns={"ID_VER_BLOCK"})})
 * @ORM\Entity
 */
class VerProcess
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="VER_PROCESS_ID_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ID_VER_BLOCK", type="integer", nullable=true)
     */
    private $idVerBlock;

    /**
     * @var string|null
     *
     * @ORM\Column(name="NOTE", type="string", length=1000, nullable=true)
     */
    private $note;

    /**
     * @var int|null
     *
     * @ORM\Column(name="PARENT_ID", type="integer", nullable=true)
     */
    private $parentId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdVerBlock(): ?int
    {
        return $this->idVerBlock;
    }

    public function setIdVerBlock(?int $idVerBlock): self
    {
        $this->idVerBlock = $idVerBlock;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    public function setParentId(?int $parentId): self
    {
        $this->parentId = $parentId;

        return $this;
    }


}
