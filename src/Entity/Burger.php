<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BurgerRepository;
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
    #[ORM\OneToOne(mappedBy: 'burger', targetEntity: MenuBurgers::class, cascade: ['persist', 'remove'])]
    private $menuBurgers;

    public function __construct()
    {
        parent::__construct();
        $this->catalogues = new ArrayCollection();
    }

    public function getMenuBurgers(): ?MenuBurgers
    {
        return $this->menuBurgers;
    }

    public function setMenuBurgers(?MenuBurgers $menuBurgers): self
    {
        // unset the owning side of the relation if necessary
        if ($menuBurgers === null && $this->menuBurgers !== null) {
            $this->menuBurgers->setBurger(null);
        }

        // set the owning side of the relation if necessary
        if ($menuBurgers !== null && $menuBurgers->getBurger() !== $this) {
            $menuBurgers->setBurger($this);
        }

        $this->menuBurgers = $menuBurgers;

        return $this;
    }
}
