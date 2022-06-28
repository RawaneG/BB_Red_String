<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BoissonsRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BoissonsRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get" =>
        [
            "method" => "get",
            "normalization_context" => ["groups" => ["boissons:read"]]
        ],
        "post" =>
        [
            "method" => "post",
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "securiy_message" => "Vous n'êtes pas autorisé à utiliser ce service",
            "normalization_context" => ["groups" => ["boissons:read"]],
            "denormalization_context" => ["groups" => ["boissons:write"]]
        ]
    ],
    itemOperations: ["put", "get"]
)]
class Boissons extends Produit
{

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        "boissons:read", "boissons:write"
    ])]
    private $typeBoisson;

    #[ORM\ManyToMany(targetEntity: Menu::class, inversedBy: 'boissons')]
    private $menu;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        "boissons:read", "boissons:write"
    ])]
    private $taille;

    public function __construct()
    {
        $this->menu = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeBoisson(): ?string
    {
        return $this->typeBoisson;
    }

    public function setTypeBoisson(string $typeBoisson): self
    {
        $this->typeBoisson = $typeBoisson;

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

    public function getTaille(): ?string
    {
        return $this->taille;
    }

    public function setTaille(string $taille): self
    {
        $this->taille = $taille;

        return $this;
    }
}
