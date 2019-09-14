<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * VerProcStages
 *
 * @ORM\Table(name="VER_PROC_STAGES", uniqueConstraints={@ORM\UniqueConstraint(name="fk_ver_proc_stages", columns={"PROC_ID", "STAGE_ID", "DB_NUM"})})
 * @ORM\Entity
 */
class VerProcStages
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="VER_PROC_STAGES_ID_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="PROC_ID", type="integer", nullable=false)
     */
    private $procId;

    /**
     * @var int
     *
     * @ORM\Column(name="STAGE_ID", type="integer", nullable=false)
     */
    private $stageId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="STATUS", type="integer", nullable=true)
     */
    private $status;

    /**
     * @var string|null
     *
     * @ORM\Column(name="PARAM", type="string", length=1024, nullable=true)
     */
    private $param;

    /**
     * @var int|null
     *
     * @ORM\Column(name="DB_NUM", type="integer", nullable=true)
     */
    private $dbNum;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProcId(): ?int
    {
        return $this->procId;
    }

    public function setProcId(int $procId): self
    {
        $this->procId = $procId;

        return $this;
    }

    public function getStageId(): ?int
    {
        return $this->stageId;
    }

    public function setStageId(int $stageId): self
    {
        $this->stageId = $stageId;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getParam(): ?string
    {
        return $this->param;
    }

    public function setParam(?string $param): self
    {
        $this->param = $param;

        return $this;
    }

    public function getDbNum(): ?int
    {
        return $this->dbNum;
    }

    public function setDbNum(?int $dbNum): self
    {
        $this->dbNum = $dbNum;

        return $this;
    }


}
