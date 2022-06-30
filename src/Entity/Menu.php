<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get" =>
        [
            "method" => "get",
            "normalization_context" => ["groups" => ["menu:read"]]
        ],
        "post" =>
        [
            "method" => "post",
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'êtes pas autorisé à utiliser ce service",
            "normalization_context" => ["groups" => ["menu:read"]],
            "denormalization_context" => ["groups" => ["menu:write"]]
        ]
    ],
    itemOperations: ["put", "get"]
)]
class Menu extends Produit
{
    #[ORM\ManyToMany(targetEntity: Burger::class, mappedBy: 'menu', cascade: ['persist'])]
    #[Groups(["menu:read", "menu:write"])]
    private $burgers;

    #[ORM\ManyToMany(targetEntity: Boissons::class, mappedBy: 'menu', cascade: ['persist'])]
    #[Groups(["menu:read", "menu:write"])]
    private $boissons;

    #[ORM\ManyToMany(targetEntity: Frites::class, mappedBy: 'menu', cascade: ['persist'])]
    #[Groups(["menu:read", "menu:write"])]
    private $frites;

    public function __construct()
    {
        parent::__construct();
        $this->burgers = new ArrayCollection();
        $this->boissons = new ArrayCollection();
        $this->frites = new ArrayCollection();
    }

    /**
     * @return Collection<int, Burger>
     */
    public function getBurgers(): Collection
    {
        return $this->burgers;
    }

    public function addBurger(Burger $burger): self
    {
        if (!$this->burgers->contains($burger)) {
            $this->burgers[] = $burger;
            $burger->addMenu($this);
        }

        return $this;
    }

    public function removeBurger(Burger $burger): self
    {
        if ($this->burgers->removeElement($burger)) {
            $burger->removeMenu($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Boissons>
     */
    public function getBoissons(): Collection
    {
        return $this->boissons;
    }

    public function addBoisson(Boissons $boisson): self
    {
        if (!$this->boissons->contains($boisson)) {
            $this->boissons[] = $boisson;
            $boisson->addMenu($this);
        }

        return $this;
    }

    public function removeBoisson(Boissons $boisson): self
    {
        if ($this->boissons->removeElement($boisson)) {
            $boisson->removeMenu($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Frites>
     */
    public function getFrites(): Collection
    {
        return $this->frites;
    }

    public function addFrite(Frites $frite): self
    {
        if (!$this->frites->contains($frite)) {
            $this->frites[] = $frite;
            $frite->addMenu($this);
        }

        return $this;
    }

    public function removeFrite(Frites $frite): self
    {
        if ($this->frites->removeElement($frite)) {
            $frite->removeMenu($this);
        }

        return $this;
    }
}
