<?php

namespace App\Entity;

use App\Entity\NormBlock;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * VerBlocks
 *
 * @ORM\Table(
 *     name="NORM_BLOCK",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(
 *             name="PK_NORM_BLOCK_ID", columns={"ID"}
 *         )
 *     },
 * )
 * @Gedmo\Tree(type="nested")
 * @ORM\Entity(repositoryClass="App\Repository\NormBlockRepository")
 *
 */
class NormBlock
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID", type="integer", nullable=false, options={"comment"="id"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="SEQ_NORM_BLOCK_ID", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @Gedmo\TreeLeft
     * @ORM\Column(name="LGT", type="integer")
     */
    private $lft;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(name="LVL", type="integer")
     */
    private $lvl;

    /**
     * @Gedmo\TreeRight
     * @ORM\Column(name="RGT", type="integer")
     */
    private $rgt;

    /**
     *
     * @ORM\ManyToOne(targetEntity="NormBlock", inversedBy="children")
     * @ORM\JoinColumn(name="PARENT_ID", referencedColumnName="ID", nullable=true)
     * @Gedmo\TreeParent
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="NormBlock", mappedBy="PARENT_ID")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;

    /**
     * @var string|null
     *
     * @ORM\Column(name="NAME", type="string", length=1000, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="CODE", type="string", length=3)
     */
    private $code;

    /**
     *
     * No mapped properties
     */

    private $indentedName;

    public function getIndentedName() {
        return str_repeat('#tab', $this->lvl) . $this->name;
    }

    /** END (No mapped properties) */

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getLevel(): int
    {
        return $this->lvl;
    }

}
