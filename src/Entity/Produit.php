<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "type", type: "string")]
#[ORM\DiscriminatorMap([
    "menu" => "Menu",
    "burger" => "Burger",
    "frites" => "Frites",
    "boissons" => "Boissons"
])]
#[ApiResource(
    collectionOperations: ["get", "post"],
    itemOperations: ["put", "get"]
)]
abstract class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups([
        "item:put_burger:read",
        "collection:post_menu:write"
    ])]
    protected $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        "collection:post_burger:write", "collection:post_burger:read",
        "collection:get_burger",
        "item:put_burger:write", "item:put_burger:read", "item:get_burger",
        "collection:post_frites:read", "collection:post_frites:write",
        "collection:get_frites",
        "item:put_frites:write", "item:put_frites:read", "item:get_frites",
        "collection:post_boissons:read", "collection:post_boissons:write",
        "collection:get_boissons",
        "item:put_boissons:write", "item:put_boissons:read", "item:get_boissons",
        "collection:post_menu:read", "collection:post_menu:write"
    ])]
    protected $nom;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        "collection:post_burger:write", "collection:post_burger:read",
        "collection:get_burger",
        "item:put_burger:write", "item:put_burger:read", "item:get_burger",
        "collection:post_frites:read", "collection:post_frites:write",
        "collection:get_frites",
        "item:put_frites:write", "item:put_frites:read", "item:get_frites",
        "collection:post_boissons:read", "collection:post_boissons:write",
        "collection:get_boissons",
        "item:put_boissons:write", "item:put_boissons:read", "item:get_boissons",
        "collection:post_menu:read", "collection:post_menu:write"
    ])]
    protected $prix;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups([
        "collection:post_burger:write", "collection:post_burger:read",
        "collection:get_burger",
        "item:put_burger:write", "item:put_burger:read", "item:get_burger",
        "collection:post_frites:read", "collection:post_frites:write",
        "collection:get_frites",
        "item:put_frites:write", "item:put_frites:read", "item:get_frites",
        "collection:post_boissons:read", "collection:post_boissons:write",
        "collection:get_boissons",
        "item:put_boissons:write", "item:put_boissons:read", "item:get_boissons",
        "collection:post_menu:read", "collection:post_menu:write"
    ])]
    protected $image;

    #[ORM\Column(type: 'boolean')]
    #[Groups([
        "item:put_burger:write", "item:put_burger:read", "item:get_burger",
        "item:put_frites:write", "item:put_frites:read", "item:get_frites",
        "item:put_boissons:write", "item:put_boissons:read", "item:get_boissons"
    ])]
    protected $isAvailable;

    #[ORM\ManyToMany(targetEntity: Commande::class, inversedBy: 'produits')]
    private $commande;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'produits')]
    #[Groups([
        "collection:post_burger:read",
        "item:put_burger:read", "item:get_burger",
        "collection:post_frites:read",
        "item:put_frites:read", "item:get_frites",
        "collection:post_boissons:read",
        "item:put_boissons:read", "item:get_boissons",
        "collection:post_menu:read"
    ])]
    private $gestionnaire;

    public function __construct()
    {
        $this->isAvailable = true;
        $this->commande = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }

    public function isIsAvailable(): ?bool
    {
        return $this->isAvailable;
    }

    public function setIsAvailable(bool $isAvailable): self
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommande(): Collection
    {
        return $this->commande;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commande->contains($commande)) {
            $this->commande[] = $commande;
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        $this->commande->removeElement($commande);

        return $this;
    }

    public function getGestionnaire(): ?Gestionnaire
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self
    {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }
}
