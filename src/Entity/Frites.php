<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FritesRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FritesRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get" =>
        [
            "method" => "get",
            "normalization_context" => ["groups" => ["frites:read"]]
        ],
        "post" =>
        [
            "method" => "post",
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'êtes pas autorisé à utiliser ce service",
            "normalization_context" => ["groups" => ["frites:read"]],
            "denormalization_context" => ["groups" => ["frites:write"]]
        ]
    ],
    itemOperations: ["put", "get"]
)]
class Frites extends Produit
{

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        "frites:read", "frites:write",
        "menu:read", "menu:write"
    ])]
    private $portions;

    #[ORM\ManyToMany(targetEntity: Menu::class, inversedBy: 'frites')]
    private $menu;

    public function __construct()
    {
        parent::__construct();
        $this->nom = "Frites";
        $this->menu = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPortions(): ?string
    {
        return $this->portions;
    }

    public function setPortions(string $portions): self
    {
        $this->portions = $portions;

        return $this;
    }

    /**
     * @return Collection<int, Menu>
     */
    public function getMenu(): Collection
    {
        return $this->menu;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menu->contains($menu)) {
            $this->menu[] = $menu;
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        $this->menu->removeElement($menu);

        return $this;
    }
}
