<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(
 *     name="MENU_TYPE",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(
 *             name="PK_MTYPE_ID", columns={"ID"}
 *         )
 *     },
 * )
 * @ORM\Entity(repositoryClass="App\Repository\MenuTypeRepository")
 */
class MenuType
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="SEQ_MENU_TYPE_ID", allocationSize=1, initialValue=1)
     * @ORM\Column(name="ID", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="TITLE", type="string", length=100)
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Menu", mappedBy="menuTypeId")
     */
    private $typeId;

    public function __construct()
    {
        $this->typeId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return Collection|Menu[]
     */
    public function getTypeId(): Collection
    {
        return $this->typeId;
    }

    public function addTypeId(Menu $menuTypeId): self
    {
        if (!$this->typeId->contains($menuTypeId)) {
            $this->typeId[] = $menuTypeId;
            $menuTypeId->setTypeId($this);
        }

        return $this;
    }

    public function removeTypeId(Menu $menuTypeId): self
    {
        if ($this->typeId->contains($menuTypeId)) {
            $this->typeId->removeElement($menuTypeId);
            // set the owning side to null (unless already changed)
            if ($menuTypeId->getTypeId() === $this) {
                $menuTypeId->setTypeId(null);
            }
        }

        return $this;
    }
}
