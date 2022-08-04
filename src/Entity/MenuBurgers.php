<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuBurgersRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MenuBurgersRepository::class)]
#[ApiResource()]
class MenuBurgers
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(["post:write:menu", "post:read:menu", "get:menu"])]
    private $quantite;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menuBurgers')]
    private $menu;

    #[ORM\OneToOne(inversedBy: 'menuBurgers', targetEntity: Burger::class, cascade: ['persist', 'remove'])]
    #[Groups(["post:write:menu", "post:read:menu", "get:menu"])]
    private $burger;

    public function __construct()
    {
        $this->quantite = 1;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }

    public function getBurger(): ?Burger
    {
        return $this->burger;
    }

    public function setBurger(?Burger $burger): self
    {
        $this->burger = $burger;

        return $this;
    }
}
