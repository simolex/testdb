<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * VerBlocks
 *
 * @ORM\Table(name="VER_BLOCKS", indexes={@ORM\Index(name="i$og$ver_blocks$type", columns={"VER_TYPE"}), @ORM\Index(name="i$og$ver_blocks$kind", columns={"ATTR", "MESSAGE"}), @ORM\Index(name="i$og$ver_blocks$block_type", columns={"BLOCK_TYPE"})})
 * @ORM\Entity
 * @UniqueEntity(
 *     fields={"vertype", "attr","message"},
 *     errorPath="message",
 *     message="Такой тип проверки данных уже существует."
 * )
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
     * @ORM\Column(name="ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="VER_BLOCKS_ID_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var int|null
     *
     * @ORM\Column(name="BLOCK_TYPE", type="integer", nullable=true)
     */
    private $blockType;

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

    public function getBlockType(): ?int
    {
        return $this->blockType;
    }

    public function setBlockType(?int $blockType): self
    {
        $this->blockType = $blockType;

        return $this;
    }


}
