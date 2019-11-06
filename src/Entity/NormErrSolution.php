<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     name="NORM_ERR_SLT",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(
 *             name="PK_NORM_ERR_SLT_ID", columns={"ID"}
 *         )
 *     },
 * )
 *
 * @ORM\Entity(repositoryClass="App\Repository\NormErrSolutionRepository")
 */
class NormErrSolution
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="SEQ_NORM_ERR_SLT_ID", allocationSize=1, initialValue=1)
     * @ORM\Column(name="ID", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="OBJ_ID", type="integer")
     */
    private $objectId;

    /**
     * @ORM\Column(name="BLOCK_ID", type="integer")
     */
    private $blockId;

    /**
     * @ORM\Column(name="NORM_VALUES", type="json", nullable=true)
     */
    private $value = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObjectId(): ?int
    {
        return $this->objectId;
    }

    public function setObjectId(int $objectId): self
    {
        $this->objectId = $objectId;

        return $this;
    }

    public function getBlockId(): ?int
    {
        return $this->blockId;
    }

    public function setBlockId(int $blockId): self
    {
        $this->blockId = $blockId;

        return $this;
    }

    public function getValue(): ?array
    {
        return $this->value;
    }

    public function setValue(?array $value): self
    {
        $this->value = $value;

        return $this;
    }
}
