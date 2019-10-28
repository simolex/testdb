<?php

namespace App\Entity;

use App\Entity\Menu;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 *  @ORM\Table(
 *     name="MENU",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(
 *             name="PK_MENU_ID", columns={"ID"}
 *         )
 *     },
 * )
 * @ORM\Entity(repositoryClass="App\Repository\MenuRepository")
 */
class Menu
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="SEQ_MENU_ID", allocationSize=1, initialValue=1)
     * @ORM\Column(name="ID", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="TITLE", type="string", length=100)
     */
    private $title;

    /**
     * @ORM\Column(name="ROUTE", type="string", length=100)
     */
    private $route;

    /**
     * @ORM\Column(name="ALIAS", type="string", length=255, nullable=true)
     */
    private $alias;

    /**
     * @ORM\Column(name="STATIC", type="boolean")
     */
    private $static;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MenuType", inversedBy="typeId")
     * @ORM\JoinColumn(name="menuTypeId", referencedColumnName="ID")
     */
    private $menuTypeId;

    /**
     * @ORM\ManyToOne(targetEntity="Menu", inversedBy="children")
     * @ORM\JoinColumn(name="PARENT_ID", referencedColumnName="ID", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Menu", mappedBy="parent")
     */
    private $children;

    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
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

    public function getRoute(): ?string
    {
        return $this->route;
    }

    public function setRoute(string $route): self
    {
        $this->route = $route;

        return $this;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(?string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    public function getStatic(): ?bool
    {
        return $this->static;
    }

    public function setStatic(bool $static): self
    {
        $this->static = $static;

        return $this;
    }

    public function getMenuTypeId(): ?MenuType
    {
        return $this->menuTypeId;
    }

    public function setMenuTypeId(?MenuType $menuTypeId): self
    {
        $this->menuTypeId = $menuTypeId;

        return $this;
    }

    /**
     * Set parent
     *
     * @param App\Entity\Menu $parent
     * @return Menu
     */
    public function setParent(?Menu $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return App\Entity\Menu
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add children
     *
     * @param App\Entity\Menu $children
     * @return Menu
     */
    public function addChildren(Menu $children): self
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param App\Entity\Menu $children
     */
    public function removeChildren(Menu $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }
}
