<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VerBlocks
 *
 * @ORM\Table(
 *     name="VER_BLOCKS",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="i_og_ver_blocks_code", columns={"ID"})},
 *     indexes={
 *         @ORM\Index(name="i_og_ver_blocks_type", columns={"VER_TYPE"}),
 *         @ORM\Index(name="i_og_ver_blocks_kind", columns={"ATTR", "MESSAGE"}),
 *         @ORM\Index(name="i_og_ver_blocks_block_type", columns={"BLOCK_TYPE"})
 *      }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\VerBlocksRepository")
 */
class VerBlocks
{
    /**
     * @var string|null
     *
     * @ORM\Column(name="VER_TYPE", type="string", length=1000, nullable=true)
     */
    private $verType;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ATTR", type="string", length=1000, nullable=true)
     */
    private $attr;

    /**
     * @var string|null
     *
     * @ORM\Column(name="MESSAGE", type="string", length=1000, nullable=true)
     */
    private $message;

    /**
     * @var int
     *
     * @ORM\Column(name="ID", type="integer", nullable=false, options={"comment"="kls_code"})
     */
    private $id;

    /**
     * @var int|null
     *
     * @ORM\Column(name="BLOCK_TYPE", type="integer", nullable=true)
     */
    private $blockType;

    /**
     * @var int
     *
     * @ORM\Column(name="BL_ID", type="integer", nullable=false, options={"comment"="id"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="VER_BLOCKS_BL_ID_seq", allocationSize=1, initialValue=1)
     */
    private $blId;

    public function getVerType(): ?string
    {
        return $this->verType;
    }

    public function setVerType(?string $verType): self
    {
        $this->verType = $verType;

        return $this;
    }

    public function getAttr(): ?string
    {
        return $this->attr;
    }

    public function setAttr(?string $attr): self
    {
        $this->attr = $attr;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getBlockType(): ?int
    {
        return $this->blockType;
    }

    public function setBlockType(?int $blockType): self
    {
        $this->blockType = $blockType;

        return $this;
    }

    public function getBlId(): ?int
    {
        return $this->blId;
    }


}
