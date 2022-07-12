<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get" =>
        [
            "method" => "get",
            "normalization_context" => ["groups" => ["get:menu"]]
        ],
        "post" =>
        [
            "method" => "post",
            "normalization_context" => ["groups" => ["post:read:menu"]],
            "denormalization_context" => ["groups" => ["post:write:menu"]]
        ],
    ],
    itemOperations: [
        'get' =>
        [
            "method" => "get"
        ]
    ]
)]
class Menu extends Produit
{
    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuFrites::class, cascade: ['persist'])]
    #[SerializedName("Frites")]
    #[Groups(["post:write:menu"])]
    private $menuFrites;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuBurgers::class, cascade: ['persist'])]
    #[SerializedName("Burgers")]
    #[Groups(["post:write:menu"])]
    private $menuBurgers;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuBoissons::class, cascade: ['persist'])]
    #[SerializedName("Boissons")]
    #[Groups(["post:write:menu"])]
    private $menuBoissons;

    public function __construct()
    {
        parent::__construct();
        $this->menuFrites = new ArrayCollection();
        $this->menuBurgers = new ArrayCollection();
        $this->menuBoissons = new ArrayCollection();
    }

    /**
     * @return Collection<int, MenuFrites>
     */
    public function getMenuFrites(): Collection
    {
        return $this->menuFrites;
    }

    public function addMenuFrite(MenuFrites $menuFrite): self
    {
        if (!$this->menuFrites->contains($menuFrite)) {
            $this->menuFrites[] = $menuFrite;
            $menuFrite->setMenu($this);
        }

        return $this;
    }

    public function removeMenuFrite(MenuFrites $menuFrite): self
    {
        if ($this->menuFrites->removeElement($menuFrite)) {
            // set the owning side to null (unless already changed)
            if ($menuFrite->getMenu() === $this) {
                $menuFrite->setMenu(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MenuBurgers>
     */
    public function getMenuBurgers(): Collection
    {
        return $this->menuBurgers;
    }

    public function addMenuBurger(MenuBurgers $menuBurger): self
    {
        if (!$this->menuBurgers->contains($menuBurger)) {
            $this->menuBurgers[] = $menuBurger;
            $menuBurger->setMenu($this);
        }

        return $this;
    }

    public function removeMenuBurger(MenuBurgers $menuBurger): self
    {
        if ($this->menuBurgers->removeElement($menuBurger)) {
            // set the owning side to null (unless already changed)
            if ($menuBurger->getMenu() === $this) {
                $menuBurger->setMenu(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MenuBoissons>
     */
    public function getMenuBoissons(): Collection
    {
        return $this->menuBoissons;
    }

    public function addMenuBoisson(MenuBoissons $menuBoisson): self
    {
        if (!$this->menuBoissons->contains($menuBoisson)) {
            $this->menuBoissons[] = $menuBoisson;
            $menuBoisson->setMenu($this);
        }

        return $this;
    }

    public function removeMenuBoisson(MenuBoissons $menuBoisson): self
    {
        if ($this->menuBoissons->removeElement($menuBoisson)) {
            // set the owning side to null (unless already changed)
            if ($menuBoisson->getMenu() === $this) {
                $menuBoisson->setMenu(null);
            }
        }

        return $this;
    }
}
