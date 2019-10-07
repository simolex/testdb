<?php

namespace App\Entity;

use App\Entity\Repository\NormBlockRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
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
 * @ORM\Entity(repositoryClass="App\Entity\Repository\NormBlockRepository")
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
     * @ORM\OneToMany(targetEntity="App\Entity\NormBlock", mappedBy="parent_id")
     */
    private $Id;

    /**
     * @var int|null
     *
     * @ORM\Column(name="PARENT_ID", type="integer", nullable=true)
     * @ORM\ManyToOne(targetEntity="App\Entity\NormBlock", inversedBy="childs")
     */
    private $parent_id;

    /**
     *
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    /*private $childs;*/

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

    /*public function __construct()
    {
        $this->childs = new ArrayCollection();
    }*/

    public function getId(): int
    {
        return $this->Id;
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

    public function getParentId(): ?self
    {
        return $this->parent_id;
    }

    public function setParentId(?self $parent_id): self
    {
        $this->parent_id = $parent_id->getId();

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    /*public function getChilds(): Collection
    {
        return $this->childs;
    }

    public function addChild(self $child): self
    {
        if (!$this->childs->contains($child)) {
            $this->childs[] = $child;
            $child->setParentId($this);
        }

        return $this;
    }*/

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /*public function getFullCode(): ?string
    {
    	$fullCode=[];
    	$parentBlock = $this;
    	do{
    		array_unshift($fullCode, $parentBlock->getCode());
    		$parentBlock = $parentBlock->getParentId();
    	}while ($parentBlock->parent_id !== null);
    	array_unshift($fullCode, $parentBlock->getCode());
    	return implode($fullCode);
    }*/



    /*public function removeChild(self $child): self
    {
        if ($this->childs->contains($child)) {
            $this->childs->removeElement($child);
            // set the owning side to null (unless already changed)
            if ($child->getParentId() === $this) {
                $child->setParentId(null);
            }
        }

        return $this;
    }*/
}
//@ORM\JoinColumn(name="parent_id", referencedColumnName="id")
//