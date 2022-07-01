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
            "normalization_context" => ["groups" => ["collection:get_menu"]]
        ],
        "post" =>
        [
            "method" => "post",
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'êtes pas autorisé à utiliser ce service",
            "normalization_context" => ["groups" => ["collection:post_menu:read"]],
            "denormalization_context" => ["groups" => ["collection:post_menu:write"]]
        ]
    ],
    itemOperations: [
        "put" =>
        [
            "method" => "put",
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'êtes pas autorisé à utiliser ce service",
            "normalization_context" => ["groups" => ["item:put_menu:read"]],
            "denormalization_context" => ["groups" => ["item:put_menu:write"]]
        ],
        "get" =>
        [
            "method" => "get",
            "normalization_context" => ["groups" => ["item:get_menu"]]
        ]
    ]
)]
class Menu extends Produit
{
    #[ORM\ManyToMany(targetEntity: Burger::class, mappedBy: 'menu', cascade: ['persist'])]
    // #[Groups([])]
    private $burgers;

    #[ORM\ManyToMany(targetEntity: Frites::class, mappedBy: 'menu', cascade: ['persist'])]
    // #[Groups([])]
    private $frites;

    #[ORM\ManyToMany(targetEntity: TailleBoisson::class, mappedBy: 'menus', cascade: ['persist'])]
    private $tailleBoissons;

    public function __construct()
    {
        parent::__construct();
        $this->burgers = new ArrayCollection();
        $this->boissons = new ArrayCollection();
        $this->frites = new ArrayCollection();
        $this->tailleBoissons = new ArrayCollection();
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

    /**
     * @return Collection<int, TailleBoisson>
     */
    public function getTailleBoissons(): Collection
    {
        return $this->tailleBoissons;
    }

    public function addTailleBoisson(TailleBoisson $tailleBoisson): self
    {
        if (!$this->tailleBoissons->contains($tailleBoisson)) {
            $this->tailleBoissons[] = $tailleBoisson;
            $tailleBoisson->addMenu($this);
        }

        return $this;
    }

    public function removeTailleBoisson(TailleBoisson $tailleBoisson): self
    {
        if ($this->tailleBoissons->removeElement($tailleBoisson)) {
            $tailleBoisson->removeMenu($this);
        }

        return $this;
    }
}
