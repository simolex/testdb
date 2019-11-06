<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     name="NORM_OBJECT",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(
 *             name="PK_NORM_OBJECT_ID", columns={"ID"}
 *         )
 *     },
 * )
 *
 * @ORM\Entity(repositoryClass="App\Repository\NormObjectRepository")
 */
class NormObject
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="SEQ_NORM_OBJECT_ID", allocationSize=1, initialValue=1)
     * @ORM\Column(name="ID", type="integer")
     *
     */
    private $id;

    /**
     * @ORM\Column(name="CAD_NUM", type="string", length=100, nullable=true)
     */
    private $cadNumber;

    /**
     * @ORM\Column(name="REG_ID", type="integer", nullable=true)
     */
    private $regId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCadNumber(): ?string
    {
        return $this->cadNumber;
    }

    public function setCadNumber(?string $cadNumber): self
    {
        $this->cadNumber = $cadNumber;

        return $this;
    }

    public function getRegId(): ?int
    {
        return $this->regId;
    }

    public function setRegId(?int $regId): self
    {
        $this->regId = $regId;

        return $this;
    }
}
