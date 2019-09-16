<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VerBlocks
 *
 * @ORM\Table(
 *     name="VER_BLOCKS",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(
 *             name="i_og_ver_blocks_code", columns={"ID"}
 *         )
 *     },
 *     indexes={
 *         @ORM\Index(name="i_og_ver_blocks_type", columns={"VER_TYPE"}),
 *         @ORM\Index(name="i_og_ver_blocks_kind", columns={"ATTR", "MESSAGE"}),
 *         @ORM\Index(name="i_og_ver_blocks_block_type", columns={"BLOCK_TYPE"})
 *     }
 * )
 * @ORM\Entity
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
    private $klsCode;

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
    private $Id;

    private function setSplitCode()
    {
        preg_match(
            '/^(\d{1,})(\d{2,2})(\d{2,2})(\d{2,2})$/',
            $this->klsCode,
            $split
        );
        array_shift($split);
        return $split;
    }

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

    public function getKlsCode(): ?string//?int
    {
        return
            //implode(' ', $this->setSplitCode());
            $this->setSplitCode()[1];
            //$this->klsCode;
    }

    public function setKlsCode(int $klsCode): self
    {
        $this->klsCode = $klsCode;
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

    public function getId(): ?int
    {
        return $this->Id;
    }



}
