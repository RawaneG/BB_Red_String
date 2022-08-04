<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuFritesRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MenuFritesRepository::class)]
#[ApiResource()]
class MenuFrites
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(["post:write:menu", "post:read:menu", "get:menu"])]
    private $quantite;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menuFrites')]
    private $menu;

    #[ORM\OneToOne(inversedBy: 'menuFrites', targetEntity: Frites::class, cascade: ['persist', 'remove'])]
    #[Groups(["post:write:menu", "post:read:menu", "get:menu"])]
    private $frite;

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

    public function getFrite(): ?Frites
    {
        return $this->frite;
    }

    public function setFrite(?Frites $frite): self
    {
        $this->frite = $frite;

        return $this;
    }
}
