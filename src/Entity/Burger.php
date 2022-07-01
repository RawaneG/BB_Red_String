<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BurgerRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get" =>
        [
            "method" => "get",
            "normalization_context" => ["groups" => ["collection:get_burger"]]
        ],
        "post" =>
        [
            "method" => "post",
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'êtes pas autorisé à utiliser ce service",
            "normalization_context" => ["groups" => ["collection:post_burger:read"]],
            "denormalization_context" => ["groups" => ["collection:post_burger:write"]]
        ]
    ],
    itemOperations: [
        "put" =>
        [
            "method" => "put",
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'êtes pas autorisé à utiliser ce service",
            "normalization_context" => ["groups" => ["item:put_burger:read"]],
            "denormalization_context" => ["groups" => ["item:put_burger:write"]]
        ],
        "get" =>
        [
            "method" => "get",
            "normalization_context" => ["groups" => ["item:get_burger"]]
        ]
    ]
)]
class Burger extends Produit
{
    #[ORM\ManyToMany(targetEntity: Menu::class, inversedBy: 'burgers')]
    private $menu;

    public function __construct()
    {
        parent::__construct();
        $this->menu = new ArrayCollection();
        $this->catalogues = new ArrayCollection();
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
