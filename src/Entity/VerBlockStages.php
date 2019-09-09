<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VerBlockStages
 *
 * @ORM\Table(name="VER_BLOCK_STAGES")
 * @ORM\Entity
 */
class VerBlockStages
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="VER_BLOCK_STAGES_ID_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ID_BL_TYPE", type="integer", nullable=true)
     */
    private $idBlType;

    /**
     * @var int|null
     *
     * @ORM\Column(name="ORDERS", type="integer", nullable=true)
     */
    private $orders;

    /**
     * @var string
     *
     * @ORM\Column(name="PUB_NAME", type="string", length=255, nullable=false)
     */
    private $pubName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="DESC_NOTE", type="string", length=512, nullable=true)
     */
    private $descNote;

    /**
     * @var string|null
     *
     * @ORM\Column(name="SYS_NAME", type="string", length=50, nullable=true)
     */
    private $sysName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdBlType(): ?int
    {
        return $this->idBlType;
    }

    public function setIdBlType(?int $idBlType): self
    {
        $this->idBlType = $idBlType;

        return $this;
    }

    public function getOrders(): ?int
    {
        return $this->orders;
    }

    public function setOrders(?int $orders): self
    {
        $this->orders = $orders;

        return $this;
    }

    public function getPubName(): ?string
    {
        return $this->pubName;
    }

    public function setPubName(string $pubName): self
    {
        $this->pubName = $pubName;

        return $this;
    }

    public function getDescNote(): ?string
    {
        return $this->descNote;
    }

    public function setDescNote(?string $descNote): self
    {
        $this->descNote = $descNote;

        return $this;
    }

    public function getSysName(): ?string
    {
        return $this->sysName;
    }

    public function setSysName(?string $sysName): self
    {
        $this->sysName = $sysName;

        return $this;
    }


}
